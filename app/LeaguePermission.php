<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class LeaguePermission extends Model
{

    const TYPE_LIKE = 1;
    const TYPE_COMMENT = 2;

    const PERMISSION_EVERYBODY = 1;
    const PERMISSION_ONLY_MEMBERS = 2;

    public static $types = [
        self::TYPE_LIKE => self::TYPE_LIKE,
        self::TYPE_COMMENT => self::TYPE_COMMENT
    ];

    public static $permissionLevels = [
        self::PERMISSION_EVERYBODY => self::PERMISSION_EVERYBODY,
        self::PERMISSION_ONLY_MEMBERS => self::PERMISSION_ONLY_MEMBERS
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'league_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'type',
        'permission'
    ];

    /**
     * The league that the photo belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function league()
    {
        return $this->belongsTo(LeagueOrganization::class, 'league_id');
    }
}
