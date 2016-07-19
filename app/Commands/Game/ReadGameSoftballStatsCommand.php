<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\ReadGameSoftballBatterStatsCommand;
use Wooter\Commands\Game\ReadGameSoftballPitcherStatsCommand;
use Wooter\Commands\Game\ReadGameTeamSoftballStatsCommand;

class ReadGameSoftballStatsCommand extends Command implements SelfHandling
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
            'batter' => [],
            'pitcher' => [],
            'teams' => []
        ];
        
        switch($this->type) {
            case 'Batter':
                $stats['batter'] = $this->dispatchFromArray(ReadGameSoftballBatterStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'Pitcher':
                $stats['pitcher'] = $this->dispatchFromArray(ReadGameSoftballPitcherStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'all':
                $stats['batter'] = $this->dispatchFromArray(ReadGameSoftballBatterStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                $stats['pitcher'] = $this->dispatchFromArray(ReadGameSoftballPitcherStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
        }
        
        $stats['teams'] = $this->dispatchFromArray(ReadGameTeamSoftballStatsCommand::class, ['gameId' => $this->gameId]);
        
        return $stats;
        
    }
}

