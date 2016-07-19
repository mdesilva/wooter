<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    const COVER_PHOTO_PREFIX = 'team_cover_photo_';
    const LOGO_PREFIX = 'team_logo_';

    const COVER_PHOTO_DESCRIPTION = 'Cover photo of the team';
    const LOGO_DESCRIPTION = 'Logo of the team';


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sport_id',
        'captain_id',
        'cover_photo',
        'logo',
        'description',
    ];

    /**
     * The leagues that this team is playing
     */
    public function regular_stages() {
        $stagesIds = TeamStage::whereStageType(RegularStage::class)->whereTeamId($this->id)->lists('stage_id');

        return RegularStage::whereIn('id', $stagesIds)->get();
    }

    /**
     * The divisions in where this team is playing
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function divisions() {
        return $this->belongsToMany(Division::class, 'team_division', 'team_id', 'division_id');
    }

    /**
     * The leagues in where this team is playing
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function leagues() {
        return $this->belongsToMany(LeagueOrganization::class, 'team_league', 'team_id', 'league_id');
    }

    /**
     * The cover photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function cover_photo()
    {
        return $this->belongsTo(Image::class, 'cover_photo_id');
    }

    /**
     * The logo
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function logo()
    {
        return $this->belongsTo(Image::class, 'logo_id');
    }

    /**
     * The captain
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    /**
     * The sport that the team plays in
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }
    
    /**
     * The team's mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function mailbox()
    {
        return Mailbox::where('owner_id', '=', $this->id)->where('owner_type', '=', 'WooterTeam')->first(); 
    }
    
    public function playerTeams() {
        return $this->hasMany(PlayerTeam::class, 'team_id');
    }
    
    public function stats() {
        switch($this->sport->name) {
            case 'Softball':
                $stats = $this->hasMany(TeamSoftballStat::class);
                break;
            case 'Football':
                $stats = $this->hasMany(TeamFootballStat::class);
                break;
            case 'Basketball':
            default:
                $stats = $this->hasMany(TeamBasketballStat::class);
                break;
        }
        
        return $stats;
    }
}

