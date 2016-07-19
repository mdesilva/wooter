<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Team\ReadTeamBasketballStatsTotalsCommand;
use Wooter\Commands\Team\ReadTeamSoftballStatsTotalsCommand;
use Wooter\Commands\Team\ReadTeamFootballStatsTotalsCommand;

class ReadTeamStatsTotalsCommand extends Command implements SelfHandling
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
    private $request;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($userId, $sport, $request)
    {
        $this->userId = $userId;
        $this->sport = $sport;
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
                $stats = $this->dispatchFromArray(ReadTeamBasketballStatsTotalsCommand::class, ['request' => $this->request]);
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(ReadTeamSoftballStatsTotalsCommand::class, ['request' => $this->request]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(ReadTeamFootballStatsTotalsCommand::class, ['request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}

