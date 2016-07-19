<?php

namespace Wooter\Http\Requests\StaticPages;

use Wooter\Http\Requests\Request;
use Wooter\PackageRequest;
use Wooter\ServiceRequest;

class CreatePackageRequestRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'sport' => '',
            'package_type' => 'required|in:' . PackageRequest::PRO_PACKAGE . ',' . PackageRequest::ELITE_PACKAGE . ',' . PackageRequest::LEGEND_PACKAGE,
            'number_of_players' => '',
            'number_of_teams' => '',
            'number_of_games_per_team' => '',
            'full_game_footage' => '',
            'game_highlights' => '',
            'statistics' => '',
            'pro_videography' => '',
            'top_10' => '',
            'weekly_recap' => '',
            'player_photos' => '',
            'team_photos' => '',
            'promo_video' => '',
            'media_coverage' => '',
            'blog_exposure' => '',
        ];
    }
}
