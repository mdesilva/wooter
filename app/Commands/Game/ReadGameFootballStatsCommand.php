<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\ReadGameFootballQuarterbackStatsCommand;
use Wooter\Commands\Game\ReadGameFootballReceiverStatsCommand;
use Wooter\Commands\Game\ReadGameFootballDefenderStatsCommand;
use Wooter\Commands\Game\ReadGameFootballRusherStatsCommand;
use Wooter\Commands\Game\ReadGameTeamFootballStatsCommand;

class ReadGameFootballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $gameId;
    
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
    public function __construct($gameId, $request)
    {
        $this->gameId = $gameId;
        $this->type = $request['type'];
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
            'rusher' => [],
            'teams' => []
        ];
        
        switch($this->type) {
            case 'quarterback':
                $stats['quarterback'] = $this->dispatchFromArray(ReadGameFootballQuarterbackStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'receiver':
                $stats['receiver'] = $this->dispatchFromArray(ReadGameFootballReceiverStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'defender':
                $stats['defender'] = $this->dispatchFromArray(ReadGameFootballDefenderStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'rusher':
                $stats['rusher'] = $this->dispatchFromArray(ReadGameFootballRusherStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'all':
                $stats['quarterback'] = $this->dispatchFromArray(ReadGameFootballQuarterbackStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                $stats['receiver'] = $this->dispatchFromArray(ReadGameFootballReceiverStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                $stats['defender'] = $this->dispatchFromArray(ReadGameFootballDefenderStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                $stats['rusher'] = $this->dispatchFromArray(ReadGameFootballRusherStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
        }
        
        $stats['teams'] = $this->dispatchFromArray(ReadGameTeamFootballStatsCommand::class, ['gameId' => $this->gameId]);
        
        return $stats;
        
    }
}

