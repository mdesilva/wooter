<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\CreateGameSoftballBatterStatsCommand;
use Wooter\Commands\Game\CreateGameSoftballPitcherStatsCommand;
use Wooter\Commands\Team\UpdateTeamSoftballStatsCommand;

class CreateGameSoftballStatsCommand extends Command implements SelfHandling
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
            'batter' => [],
            'pitcher' => []
        ];
        
        switch($this->type) {
            case 'Batter':
                $stats['batter'] = $this->dispatchFromArray(CreateGameSoftballBatterStatsCommand::class, ['request' => $this->request]);
                break;
            case 'Pitcher':
                $stats['pitcher'] = $this->dispatchFromArray(CreateGameSoftballPitcherStatsCommand::class, ['request' => $this->request]);
                break;
            case 'all':
                $stats['batter'] = $this->dispatchFromArray(CreateGameSoftballBatterStatsCommand::class, ['request' => $this->request]);
                $stats['pitcher'] = $this->dispatchFromArray(CreateGameSoftballPitcherStatsCommand::class, ['request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}
