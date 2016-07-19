<?php

namespace Wooter\Wooter\Transformers\Game;

use Carbon\Carbon;
use Wooter\Wooter\Transformers\CompetitionWeekTransformer;
use Wooter\Wooter\Transformers\GameVenueTransformer;
use Wooter\Wooter\Transformers\Transformer;

class GamesTransformer extends Transformer
{
    public $pages;
    /**
     * @var
     */
    private $gameVenueTransformer;
    /**
     * @var CompetitionWeekTransformer
     */
    private $competitionWeekTransformer;

    /**
     * @param GameVenueTransformer       $gameVenueTransformer
     * @param CompetitionWeekTransformer $competitionWeekTransformer
     */
    public function __construct(GameVenueTransformer $gameVenueTransformer, CompetitionWeekTransformer $competitionWeekTransformer)
    {

        $this->gameVenueTransformer = $gameVenueTransformer;
        $this->competitionWeekTransformer = $competitionWeekTransformer;
    }
    
    public function transform($game)
    {
        $homeTeamStats = $game->homeTeam->stats()->where('game_id', $game->id)->first();
        $home_team_win = $homeTeamStats ? $homeTeamStats->win : '';
        $home_team_loss = $homeTeamStats ? $homeTeamStats->loss : '';
        $home_team_draw = $homeTeamStats ? $homeTeamStats->draw : '';
        
        $visitingTeamStats = $game->visitingTeam->stats()->where('game_id', $game->id)->first();
        $visiting_team_win = $visitingTeamStats ? $visitingTeamStats->win : '';
        $visiting_team_loss = $visitingTeamStats ? $visitingTeamStats->loss : '';
        $visiting_team_draw = $visitingTeamStats ? $visitingTeamStats->draw : '';

        $response = [
            'id' => $game->id,
            'game_venue' => $this->gameVenueTransformer->transform($game->game_venue),
            'location' => $game->game_venue ? $game->game_venue->location->name : null,
            'datetime' => $game->time,
            'date' => date('m/d/Y', strtotime($game->time)),
            'stage_id' => $game->stage_id,
            'stage_type' => $game->stage_type,
            'competition_id' => $game->stage->competition_id,
            'competition_type' => $game->stage->competition_type,
            'organization_id' => $game->stage->competition->organization_id,
            'organization_type' => $game->stage->competition->organization_type,
            'sport' => $game->sport->name,
            'home_team' => $game->homeTeam->name,
            'visiting_team' => $game->visitingTeam->name,
            'home_team_id' => $game->homeTeam->id,
            'visiting_team_id' => $game->visitingTeam->id,
            'home_team_score' => $game->homeTeam->stats()->where('game_id', $game->id)->first() ? $game->homeTeam->stats()->where('game_id', $game->id)->first()->final_score : '',
            'visiting_team_score' => $game->visitingTeam->stats()->where('game_id', $game->id)->first() ? $game->visitingTeam->stats()->where('game_id', $game->id)->first()->final_score : '',
            'home_team_win' => $home_team_win,
            'visiting_team_win' => $visiting_team_win,
            'home_team_loss' => $home_team_loss,
            'visiting_team_loss' => $visiting_team_loss,
            'home_team_draw' => $home_team_draw,
            'visiting_team_draw' => $visiting_team_draw,
            'home_team_logo' => $game->homeTeam->logo ? $game->homeTeam->logo->file_path : null,
            'home_team_logo_id' => $game->homeTeam->logo ? $game->homeTeam->logo->id : null,
            'visiting_team_logo' => $game->visitingTeam->logo ? $game->visitingTeam->logo->file_path : null,
            'visiting_team_logo_id' => $game->visitingTeam->logo ? $game->visitingTeam->logo->id : null,
            'week' => $this->competitionWeekTransformer->transform($game->competition_week),
            'time' => $game->time,
            'day' => $game->time->day,
            'month' => $game->time->month,
            'year' => $game->time->year,
            'hour' => $game->time->hour,
            'minute' => $game->time->minute,
            'second' => $game->time->second,
            'created_at' => $game->created_at,
            'updated_at' => $game->updated_at,
            'scored' => $home_team_win + $home_team_loss + $home_team_draw,
            'game_status' => ($game->time > Carbon::now()) ? 'scheduled' : 'completed'
        ];
        
       return $response;
    }
}

