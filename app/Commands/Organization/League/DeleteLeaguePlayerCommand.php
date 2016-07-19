<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Events\League\NotifyLeagueOwnerPlayerLeftLeagueEvent;
use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;


class DeleteLeaguePlayerCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $userId;

    /**
     * @param $league_id
     * @param $player_id
     * @param $user_id
     */
    public function __construct($league_id, $player_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->playerId = $player_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository     $leagueRepository
     *
     * @param UserRepository       $userRepository
     *
     * @param PlayerTeamRepository $playerTeamRepository
     *
     * @return bool
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerNotFound
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository, PlayerTeamRepository $playerTeamRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        DB::transaction(function () use ($league, $player, $playerTeamRepository) {

            if ($league->season_competitions) {
                $firstSeason = $league->season_competitions()->get()->first();

                if ($firstSeason->regular_stages) {
                    $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                    $playerTeamRepository->deleteByPlayerIdAndStage($player->id, RegularStage::class, $firstRegularStage->id);
                }
            }

            if (!$league->players()->detach($player->id)) {
                throw new DatabaseException;
            }

            Event::fire(new NotifyLeagueOwnerPlayerLeftLeagueEvent($league, $player));
        });

        return true;
    }
}
