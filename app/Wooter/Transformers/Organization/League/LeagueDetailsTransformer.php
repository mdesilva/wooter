<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\Transformer;

class LeagueDetailsTransformer extends Transformer
{
    public function transform($leagueDetails)
    {
        return [
            'id' => $leagueDetails->id,
            'league_id' => $leagueDetails->league_id,
            'number_of_teams' => $leagueDetails->number_of_teams,
            'description' => $leagueDetails->description,
            'players_per_team' => $leagueDetails->players_per_team,
            'max_players' => $leagueDetails->max_players,
            'game_duration' => $leagueDetails->game_duration,
            'time_period' => $leagueDetails->time_period,
            'games_per_team' => $leagueDetails->games_per_team,
        ];
    }
}