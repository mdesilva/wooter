<?php

namespace Wooter\Commands\Game;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\CompetitionWeek;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\GameNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\SportNotFound;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Repositories\CompetitionWeeksRepository;
use Wooter\Wooter\Repositories\SportRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Commands\Team\ReadTeamPlayersCommand;
use Wooter\Game;
use Wooter\Sport;
use Wooter\PlayerTeam;
use Wooter\TeamBasketballStat;
use Wooter\TeamSoftballStat;
use Wooter\TeamFootballStat;
use Wooter\PlayerBasketballStat;
use Wooter\PlayerSoftballBatterStat;
use Wooter\PlayerSoftballPitcherStat;
use Wooter\PlayerFootballQuarterbackStat;
use Wooter\PlayerFootballReceiverStat;
use Wooter\PlayerFootballDefenderStat;
use Wooter\PlayerFootballRusherStat;

class CreateGameCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
     * @var
     */
    private $userId;
    
    /**
     * @var
     */
    private $homeTeamId;
    
    /**
     * @var
     */
    private $visitingTeamId;
    
    /**
     * @var
     */
    private $sportId;
    
    /**
     * @var
     */
    private $stageId;
    
    /**
     * @var
     */
    private $stageType;
    /**
     * @var
     */
    private $time;
    /**
     * @var
     */
    private $gameVenueId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $home_team_id
     * @param $visiting_team_id
     * @param $game_venue_id
     * @param $sport_id
     * @param $stage_id
     * @param $stage_type
     * @param $time
     */
    public function __construct($user_id,
                                $home_team_id,
                                $visiting_team_id,
                                $game_venue_id,
                                $sport_id,
                                $stage_id,
                                $stage_type,
                                $time)
    {
        $this->userId = $user_id;
        $this->homeTeamId = $home_team_id;
        $this->visitingTeamId = $visiting_team_id;
        $this->sportId = $sport_id;
        $this->stageId = $stage_id;
        $this->stageType = $stage_type;
        $this->gameVenueId = $game_venue_id;
        $this->time = $time;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository             $userRepository
     * @param GamesRepository            $gamesRepository
     * @param SportRepository            $sportRepository
     * @param CompetitionWeeksRepository $competitionWeeksRepository
     * @param RegularStageRepository     $regularStageRepository
     *
     * @return bool|Game
     * @throws NotPermissionException
     * @throws RegularStageNotFound
     * @throws SportNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository,
                           GamesRepository $gamesRepository,
                           SportRepository $sportRepository,
                           CompetitionWeeksRepository $competitionWeeksRepository,
                           RegularStageRepository $regularStageRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        $stage = $regularStageRepository->getById($this->stageId);

        if (!$stage) {
            throw new RegularStageNotFound;
        }

        if ( ! $user->hasOrganization($stage->competition->organization->id)) {
            throw new NotPermissionException;
        }

        $sport = $sportRepository->getById($this->sportId);

        if (!$sport) {
            throw new SportNotFound;
        }

        $game = DB::transaction(function () use ($competitionWeeksRepository, $gamesRepository, $regularStageRepository, $sport) {

            $game = new Game;

            $game->home_team_id = $this->homeTeamId;
            $game->visiting_team_id = $this->visitingTeamId;
            $game->sport_id = $this->sportId;
            $game->stage_id = $this->stageId;
            $game->stage_type = RegularStage::class;
            $game->game_venue_id = $this->gameVenueId;
            $game->time = new Carbon($this->time);
            $game->competition_week_id = $competitionWeeksRepository->getCompetitionWeekId($this->time, $this->stageId, $this->stageType);

            $gamesRepository->create($game);

            $teamIds = [
                $this->homeTeamId,
                $this->visitingTeamId
            ];

            $stage = $regularStageRepository->getById($this->stageId);

            $playersRequest = [
                'league_id' => $stage->competition->organization->id,
                'limit' => 100
            ];

            switch ($sport->id) {
                case Sport::BASKETBALL:
                    foreach ($teamIds as $teamId) {
                        $this->createTeamBasketballStats($teamId, $game);
                        $this->createPlayerBasketballStats($teamId, $playersRequest, $game);
                    }
                    break;
                case Sport::BASEBALL:
                    foreach ($teamIds as $teamId) {
                        $this->createTeamSoftballStats($teamId, $game);
                        $this->createPlayerSoftballStats($teamId, $playersRequest, $game);
                    }
                    break;
                case Sport::FOOTBALL:
                    foreach ($teamIds as $teamId) {
                        $this->createTeamFootballStats($teamId, $game);
                        $this->createPlayerFootballStats($teamId, $playersRequest, $game);
                    }
                    break;
            }

            return $game;
        });

        return $game;
    }



    /**
     * @param $teamId
     * @param $game
     */
    private function createTeamBasketballStats($teamId, $game) {
        $teamStats = new TeamBasketballStat();
        $teamStats->team_id = $teamId;
        $teamStats->first_quarter_score = 0;
        $teamStats->second_quarter_score = 0;
        $teamStats->third_quarter_score = 0;
        $teamStats->fourth_quarter_score = 0;
        $teamStats->final_score = 0;
        $teamStats->win = 0;
        $teamStats->loss = 0;
        $teamStats->draw = 0;
        $game->stats()->save($teamStats);
    }

    /**
     * @param $teamId
     * @param $game
     */
    private function createTeamSoftballStats($teamId, $game) {
        $teamStats = new TeamSoftballStat();
        $teamStats->team_id = $teamId;
        $teamStats->first_inning_score = 0;
        $teamStats->second_inning_score = 0;
        $teamStats->third_inning_score = 0;
        $teamStats->fourth_inning_score = 0;
        $teamStats->fifth_inning_score = 0;
        $teamStats->sixth_inning_score = 0;
        $teamStats->seventh_inning_score = 0;
        $teamStats->eight_inning_score = 0;
        $teamStats->ninth_inning_score = 0;
        $teamStats->final_score = 0;
        $teamStats->win = 0;
        $teamStats->loss = 0;
        $teamStats->draw = 0;
        $game->stats()->save($teamStats);
    }

    /**
     * @param $teamId
     * @param $game
     */
    private function createTeamFootballStats($teamId, $game) {
        $teamStats = new TeamFootballStat();
        $teamStats->team_id = $teamId;
        $teamStats->first_quarter_score = 0;
        $teamStats->second_quarter_score = 0;
        $teamStats->third_quarter_score = 0;
        $teamStats->fourth_quarter_score = 0;
        $teamStats->final_score = 0;
        $teamStats->win = 0;
        $teamStats->loss = 0;
        $teamStats->draw = 0;
        $game->stats()->save($teamStats);
    }

    /**
     * @param $player
     * @param $teamId
     * @param $jersey
     *
     * @return PlayerSoftballBatterStat
     */
    private function createSoftballBatterStats($player, $teamId, $jersey) {
        $stats = new PlayerSoftballBatterStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->AB = 0;
        $stats->R = 0;
        $stats->H = 0;
        $stats->RBI = 0;
        $stats->BB = 0;
        $stats->SO = 0;
        $stats->HBP = 0;
        $stats->SF = 0;
        $stats->TB = 0;
        $stats->AVG = 0;
        $stats->OBP = 0;
        $stats->SLG = 0;
        return $stats;
    }

    /**
     * @param $player
     * @param $teamId
     * @param $jersey
     *
     * @return PlayerSoftballPitcherStat
     */
    private function createSoftballPitcherStats($player, $teamId, $jersey) {
        $stats = new PlayerSoftballPitcherStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->IP = 0;
        $stats->H = 0;
        $stats->R = 0;
        $stats->ERR = 0;
        $stats->BB = 0;
        $stats->SO = 0;
        $stats->HR = 0;
        $stats->PC = 0;
        $stats->ST = 0;
        $stats->ERA = 0;
        return $stats;
    }

    /**
     * @param $player
     * @param $teamId
     * @param $jersey
     *
     * @return PlayerFootballQuarterbackStat
     */
    private function createFootballQuarterbackStats($player, $teamId, $jersey) {
        $stats = new PlayerFootballQuarterbackStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->COMP = 0;
        $stats->ATT = 0;
        $stats->PCT = 0;
        $stats->YDS = 0;
        $stats->AVG = 0;
        $stats->TD = 0;
        $stats->INT = 0;
        $stats->SACKS = 0;
        $stats->QBR = 0;
        return $stats;
    }

    /**
     * @param $player
     * @param $teamId
     * @param $jersey
     *
     * @return PlayerFootballReceiverStat
     */
    private function createFootballReceiverStats($player, $teamId, $jersey) {
        $stats = new PlayerFootballReceiverStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->REC = 0;
        $stats->YDS = 0;
        $stats->AVG = 0;
        $stats->TD = 0;
        $stats->LONG = 0;
        $stats->TGTS = 0;
        return $stats;
    }

    /**
     * @param $player
     * @param $teamId
     * @param $jersey
     *
     * @return PlayerFootballDefenderStat
     */
    private function createFootballDefenderStats($player, $teamId, $jersey) {
        $stats = new PlayerFootballDefenderStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->INT = 0;
        $stats->YDS = 0;
        $stats->TKLS = 0;
        $stats->SACKS = 0;
        $stats->TD = 0;
        return $stats;
    }

    /**
     * @param $player
     * @param $teamId
     *
     * @return PlayerFootballRusherStat
     */
    private function createFootballRusherStats($player, $teamId, $jersey) {
        $stats = new PlayerFootballRusherStat();
        $stats->player_id = $player->id;
        $stats->team_id = $teamId;
        $stats->name = $player->first_name . ' ' . $player->last_name;
        $stats->jersey = $jersey;
        $stats->active = 0;
        $stats->CAR = 0;
        $stats->YDS = 0;
        $stats->AVG = 0;
        $stats->TD = 0;
        return $stats;
    }

    /**
     * @param $teamId
     * @param $playersRequest
     * @param $game
     */
    private function createPlayerBasketballStats($teamId, $playersRequest, $game) {
        $playersRequest['team_id'] = $teamId;
        $players = $this->dispatchFromArray(ReadTeamPlayersCommand::class, $playersRequest);
        
        foreach ($players as $player) {
            $playerTeam = PlayerTeam::where('player_id', '=', $player->id)->where('team_id', '=', $teamId)->first();
            if ($game->time > $playerTeam->joined_at) {
                $bballStat = new PlayerBasketballStat();
                $bballStat->team_id = $teamId;
                $bballStat->player_id = $player->id;
                $bballStat->points = 0;
                $bballStat->name = $player->first_name . ' ' . $player->last_name;
                $bballStat->jersey = $playerTeam->jersey;
                $bballStat->active = 0;
                $bballStat->{'3_points_shots_made'} = 0;
                $bballStat->{'3_points_shots_attempted'} = 0;
                $bballStat->assists = 0;
                $bballStat->blocked_shots = 0;
                $bballStat->field_goals_made = 0;
                $bballStat->field_goals_attempted = 0;
                $bballStat->personal_fouls = 0;
                $bballStat->free_throws_made = 0;
                $bballStat->free_throws_attempted = 0;
                $bballStat->steals = 0;
                $bballStat->turnovers = 0;
                $game->playerStats()->save($bballStat);
            }
        }
        
    }

    /**
     * @param $teamId
     * @param $playersRequest
     * @param $game
     */
    private function createPlayerSoftballStats($teamId, $playersRequest, $game) {
        $playersRequest['team_id'] = $teamId;
        $players = $this->dispatchFromArray(ReadTeamPlayersCommand::class, $playersRequest);
        foreach ($players as $player) {
            $playerTeam = PlayerTeam::where('player_id', '=', $player->id)->where('team_id', '=', $teamId)->first();
            if ($game->time > $playerTeam->joined_at) {
                foreach ($playerTeam->positions as $position) {
                    switch ($position) {
                        case 'batter': 
                            $stats = $this->createSoftballBatterStats($player, $teamId, $playerTeam->jersey);
                            break;
                        case 'pitcher':
                            $stats = $this->createSoftballPitcherStats($player, $teamId, $playerTeam->jersey);
                            break;
                    }
                    $game->playerStats()->save($stats);
                }
            }
            
            
        }
    }

    /**
     * @param $teamId
     * @param $playersRequest
     * @param $game
     */
    private function createPlayerFootballStats($teamId, $playersRequest, $game) {
        $playersRequest['team_id'] = $teamId;
        $players = $this->dispatchFromArray(ReadTeamPlayersCommand::class, $playersRequest);
        foreach ($players as $player) {
            $playerTeam = PlayerTeam::where('player_id', '=', $player->id)->where('team_id', '=', $teamId)->first();
            if ($game->time > $playerTeam->joined_at) {
                foreach ($playerTeam->positions as $position) {
                    switch ($position) {
                        case 'quarterback': 
                            $stats = $this->createFootballQuarterbackStats($player, $teamId, $playerTeam->jersey);
                            break;
                        case 'receiver':
                            $stats = $this->createFootballReceiverStats($player, $teamId, $playerTeam->jersey);
                            break;
                        case 'defender':
                            $stats = $this->createFootballDefenderStats($player, $teamId, $playerTeam->jersey);
                            break;
                        case 'rusher':
                            $stats = $this->createFootballRusherStats($player, $teamId, $playerTeam->jersey);
                            break;
                    }
                    $game->playerStats()->save($stats);
                }
            }
            
        }
    }
    
}

