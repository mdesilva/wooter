<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeagueOrganization extends Model
{
    const LOGO_DESCRIPTION = 'The logo of the league';
    const LOGO_PREFIX = 'league_logo_';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sport_id',
        'name',
        'email',
        'description',
        'image',
        'status',
        'entry',
        'modef',
        'verified',
        'facebook',
        'twitter',
        'instragram',
        'pinterest',
        'google',
        'dream_league',
    ];


    /**
     * The basic information of a league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function basics()
    {
        return $this->hasOne(LeagueBasics::class, 'league_id');
    }

    /**
     * The details of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function details()
    {
        return $this->hasOne(LeagueDetails::class, 'league_id');
    }

    /**
     * The photos of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function photos()
    {
        return $this->hasMany(LeaguePhoto::class, 'league_id');
    }

    /**
     * The seasons of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function seasons()
    {
        return $this->morphMany(SeasonCompetition::class, 'organization');
    }

    /**
     * The videos of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function videos()
    {
        return $this->hasMany(LeagueVideo::class, 'league_id');
    }

    

    /**
     * The teams that play in the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_league', 'league_id', 'team_id');
    }

    /**
     * The players that play in the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(User::class, 'player_league', 'league_id', 'player_id');
    }

    /**
     * The game venue where the league plays
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function game_venues()
    {
        return $this->belongsToMany(GameVenue::class, 'league_game_venues', 'league_id', 'game_venue_id');
    }

    /**
     * The locations of the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'league_locations', 'league_id', 'location_id');
    }

    /**
     * The league's mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function mailbox()
    {
        return Mailbox::where('owner_id', '=', $this->id)->where('owner_type', '=', 'WooterLeague')->first(); 
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function season_competitions()
    {
        return $this->morphMany(SeasonCompetition::class, 'organization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
