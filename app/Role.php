<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Role types
     */
    const ATHLETE = 1;
    const PLAYER = 1;
    const TEAM_CAPTAIN = 2;
    const ORGANIZATION = 3;
    const ORGANIZATION_STAFF = 4;
    const ADMIN = 5;
    const DEVELOPER = 6;

    const PLAYER_NAME = 'Player';
    const TEAM_CAPTAIN_NAME = 'Team Captain';
    const ORGANIZATION_NAME = 'Organization';
    const ORGANIZATION_STAFF_NAME = 'Organization Staff';
    const ADMIN_NAME = 'Admin';
    const DEVELOPER_NAME = 'Developer';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
