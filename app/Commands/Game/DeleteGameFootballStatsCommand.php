<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\DeleteGameFootballQuarterbackStatsCommand;
use Wooter\Commands\Game\DeleteGameFootballReceiverStatsCommand;
use Wooter\Commands\Game\DeleteGameFootballDefenderStatsCommand;
use Wooter\Commands\Game\DeleteGameFootballRusherStatsCommand;

class DeleteGameFootballStatsCommand extends Command implements SelfHandling
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
            case 'Quarterback':
                $success = $this->dispatchFromArray(DeleteGameFootballQuarterbackStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'Receiver':
                $success = $this->dispatchFromArray(DeleteGameFootballReceiverStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'Defender':
                $success = $this->dispatchFromArray(DeleteGameFootballDefenderStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'Rusher':
                $success = $this->dispatchFromArray(DeleteGameFootballRusherStatsCommand::class, ['gameId' => $this->gameId]);
                break;
            case 'all':
                $success = $this->dispatchFromArray(DeleteGameFootballQuarterbackStatsCommand::class, ['gameId' => $this->gameId]);
                $success = $this->dispatchFromArray(DeleteGameFootballReceiverStatsCommand::class, ['gameId' => $this->gameId]);
                $success = $this->dispatchFromArray(DeleteGameFootballDefenderStatsCommand::class, ['gameId' => $this->gameId]);
                $success = $this->dispatchFromArray(DeleteGameFootballRusherStatsCommand::class, ['gameId' => $this->gameId]);
                break;
        }
        
        return $success;
        
    }
}
