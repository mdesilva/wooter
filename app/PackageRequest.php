<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class PackageRequest extends Model
{
    const PRO_PACKAGE = 1;
    const ELITE_PACKAGE = 2;
    const LEGEND_PACKAGE = 3;

    public static $packageTypes = [
        self::PRO_PACKAGE => 'Pro Package',
        self::ELITE_PACKAGE => 'Elite Package',
        self::LEGEND_PACKAGE => 'Legend Package',
    ];

    public static function getPackageName($package_type) {
        if ($package_type == 1) {
            return 'Pro Package';
        } else if ($package_type == 2) {
            return 'Elite Package';
        } else if ($package_type == 3) {
            return 'Legend Package';
        }
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'package_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'phone',
        'sport',
        'package_type',
        'number_of_players',
        'number_of_teams',
        'number_of_games_per_team',
        'full_game_footage',
        'game_highlights',
        'statistics',
        'pro_videography',
        'top_10',
        'weekly_recap',
        'player_photos',
        'team_photos',
        'promo_video',
        'media_coverage',
        'blog_exposure',
    ];
}
