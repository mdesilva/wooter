<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeaguePasscode extends Model
{
    const PASSCODE = "PASS-";

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'league_passcodes';




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'passcode',

    ];

    /**
     * The passcode that is belong to league
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class);
    }
}
