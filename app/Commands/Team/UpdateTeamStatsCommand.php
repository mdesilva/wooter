<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Team\UpdateTeamBasketballStatsCommand;
use Wooter\Commands\Team\UpdateTeamSoftballStatsCommand;
use Wooter\Commands\Team\UpdateTeamFootballStatsCommand;

class UpdateTeamStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $userId;
    
    /**
     * @var
     */
    private $sport;
    
    /**
    * @var
    */
    private $teamId;
    
    /**
    * @var
    */
    private $gameId;
    
    /**
    * @var
    */
    private $request;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($userId, $sport, $teamId, $gameId, $request)
    {
        $this->userId = $userId;
        $this->sport = $sport;
        $this->teamId = $teamId;
        $this->gameId = $gameId;
        $this->request = $request;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle()
    {
        switch($this->sport) {
            case 'Basketball':
                $stats = $this->dispatchFromArray(UpdateTeamBasketballStatsCommand::class, ['request' => $this->request, 'teamId' => $this->teamId, 'gameId' => $this->gameId]);
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(UpdateTeamSoftballStatsCommand::class, ['request' => $this->request, 'teamId' => $this->teamId, 'gameId' => $this->gameId]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(UpdateTeamFootballStatsCommand::class, ['request' => $this->request, 'teamId' => $this->teamId, 'gameId' => $this->gameId]);
                break;
        }
        
        return $stats;
        
    }
}

