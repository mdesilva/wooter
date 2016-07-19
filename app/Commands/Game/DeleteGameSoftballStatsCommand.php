<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\DeleteGameSoftballBatterStatsCommand;
use Wooter\Commands\Game\DeleteGameSoftballPitcherStatsCommand;

class DeleteGameSoftballStatsCommand extends Command implements SelfHandling
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
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($gameId, $type)
    {
        $this->gameId = $gameId;
        $this->type = $type;
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
        switch($this->type) {
            case 'Batter':
                $success = $this->dispatchFromArray(DeleteGameSoftballBatterStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'Pitcher':
                $success = $this->dispatchFromArray(DeleteGameSoftballPitcherStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'all':
                $success = $this->dispatchFromArray(DeleteGameSoftballBatterStatsCommand::class, ['gameId' => $this->gameId]);
                $success = $this->dispatchFromArray(DeleteGameSoftballPitcherStatsCommand::class, ['gameId' => $this->gameId]);
                break;
        }
        
        return $success;
        
    }
}

