<?php

namespace Wooter;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Wooter\Wooter\Contracts\Auth\CanVerifyUser as CanVerifyUserContract;
use Wooter\Wooter\Auth\VerifyUser\CanVerifyUser;
use Wooter\Wooter\Traits\User\UserRoleActions;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    CanVerifyUserContract
{

    const GENDER_FEMALE = 'female';
    const GENDER_MALE = 'male';
    const GENDER_OTHER = 'other';

    const FACEBOOK_INTEGRATED_FALSE = 0;
    const FACEBOOK_INTEGRATED_TRUE = 1;

    const DEFAULT_PASSWORD = 'wooter123';

    use Authenticatable, Authorizable, CanResetPassword, CanVerifyUser, UserRoleActions;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'valid',
        'key',
        'image_id',
        'referral_user_id',
        'user_key',
        'soc_id',
        'type_network',
        'phone',
        'facebook_id',
        'gender',
        'preselected_role',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The roles that belong to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * The picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function picture()
    {
        return $this->belongsTo(Image::class, 'picture_id');
    }

    /**
     * The leagues where the player plays
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leagues()
    {
        return $this->belongsToMany(LeagueOrganization::class, 'player_league', 'player_id', 'league_id');
    }

    /**
     * @param $organizationId
     *
     * @return bool
     */
    public function hasOrganization($organizationId) {
        $organization = LeagueOrganization::where('id', '=', $organizationId)->first();

        if ($organization && $organization->user->id === $this->id) {
            return true;
        }

        return false;
    }

    /**
     * @param $competitionId
     *
     * @return bool
     */
    public function hasCompetition($competitionId) {
        $competition = SeasonCompetition::where('id', '=', $competitionId)->first();

        if ($competition && $competition->organization->user->id === $this->id) {
            return true;
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function league_organizations()
    {
        return $this->hasMany(LeagueOrganization::class, 'user_id');
    }

    /**
     * The user's mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function mailbox()
    {
        return Mailbox::where('owner_id', '=', $this->id)->where('owner_type', '=', 'WooterUser')->first(); 
    }
    
    /**
     * The user's stats
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function stats()
    {
        return $this->hasMany(PlayerBasketballStat::class, 'player_id');
    }
    
    public function beNotifiedViaSMS()
    {
        return true;
    }

    public function beNotifiedViaEmail()
    {
        return true;
    }
    
    public function leagueMailbox($id) {
        $league = $this->leagues()
                       ->where('id', intval($id))
                       ->first();

        return $league ? $league->mailbox() : false;
    }
    
    public function teamMailbox($id) {
        $team = $this->teams()
                     ->where('teams.id', '=', $id)
                     ->first();
        
        return $team ? $team->mailbox() : false;
    }
    
    public function getMailbox($club_type, $club_id) {

        if ($club_type == 'league') {
            $mailbox = $this->leagueMailbox($club_id);
        } else if ($club_type == 'team') {
            $mailbox = $this->teamMailbox($club_id);
        } else {
            $mailbox = $this->mailbox();
        }

        return $mailbox;
    }

    /**
     * @return User
     */
    public function verify()
    {
        $this->verified = 1;

        $this->save();

        return $this;
    }

}
