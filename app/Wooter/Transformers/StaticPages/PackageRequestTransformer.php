<?php

namespace Wooter\Wooter\Transformers\StaticPages;
use Wooter\PackageRequest;
use Wooter\Wooter\Transformers\Transformer;

class PackageRequestTransformer extends Transformer
{
    public function transform($packageRequest)
    {
        return [
            'id' => $packageRequest->id,
            'email' => $packageRequest->email,
            'name' => $packageRequest->name,
            'phone' => $packageRequest->phone,
            'sport' => $packageRequest->sport,
            'package_type' => $packageRequest->package_type,
            'package_name' => PackageRequest::getPackageName($packageRequest->package_type),
            'number_of_teams' => $packageRequest->number_of_teams,
            'number_of_players' => $packageRequest->number_of_players,
            'number_of_games_per_team' => $packageRequest->number_of_games_per_team,
            'full_game_footage' => $packageRequest->full_game_footage,
            'game_highlights' => $packageRequest->game_highlights,
            'statistics' => $packageRequest->statistics,
            'pro_videography' => $packageRequest->pro_videography,
            'top_10' => $packageRequest->top_10,
            'weekly_recap' => $packageRequest->weekly_recap,
            'player_photos' => $packageRequest->player_photos,
            'team_photos' => $packageRequest->team_photos,
            'promo_video' => $packageRequest->promo_video,
            'media_coverage' => $packageRequest->media_coverage,
            'blog_exposure' => $packageRequest->blog_exposure,
        ];
    }
}