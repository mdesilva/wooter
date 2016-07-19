<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\CreateGameFootballQuarterbackStatsCommand;
use Wooter\Commands\Game\CreateGameFootballReceiverStatsCommand;
use Wooter\Commands\Game\CreateGameFootballDefenderStatsCommand;
use Wooter\Commands\Game\CreateGameFootballRusherStatsCommand;
use Wooter\Commands\Team\UpdateTeamFootballStatsCommand;

class CreateGameFootballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $type;
    
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
    public function __construct($type, $request)
    {
        $this->type = $type;
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
        $stats = [
            'quarterback' => [],
            'receiver' => [],
            'defender' => [],
            'rusher' => []
        ];
        
        switch($this->type) {
            case 'Quarterback':
                $stats['quarterback'] = $this->dispatchFromArray(CreateGameFootballQuarterbackStatsCommand::class, ['request' => $this->request]);
                break;
            case 'Receiver':
                $stats['receiver'] = $this->dispatchFromArray(CreateGameFootballReceiverStatsCommand::class, ['request' => $this->request]);
                break;
            case 'Defender':
                $stats['defender'] = $this->dispatchFromArray(CreateGameFootballDefenderStatsCommand::class, ['request' => $this->request]);
                break;
            case 'Rusher':
                $stats['rusher'] = $this->dispatchFromArray(CreateGameFootballRusherStatsCommand::class, ['request' => $this->request]);
                break;
            case 'all':
                $stats['quarterback'] = $this->dispatchFromArray(CreateGameFootballQuarterbackStatsCommand::class, ['request' => $this->request]);
                $stats['receiver'] = $this->dispatchFromArray(CreateGameFootballReceiverStatsCommand::class, ['request' => $this->request]);
                $stats['defender'] = $this->dispatchFromArray(CreateGameFootballDefenderStatsCommand::class, ['request' => $this->request]);
                $stats['rusher'] = $this->dispatchFromArray(CreateGameFootballRusherStatsCommand::class, ['request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}

