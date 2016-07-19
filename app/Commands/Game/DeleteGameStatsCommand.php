<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\DeleteGameBasketballStatsCommand;
use Wooter\Commands\Game\DeleteGameFootballStatsCommand;
use Wooter\Commands\Game\DeleteGameSoftballStatsCommand;

class DeleteGameStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $userId;
    
    /**
    * @var
    */
    private $gameId;
    
    /**
     * @var
     */
    private $sport;
    
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
    public function __construct($userId, $gameId, $sport, $type)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->sport = $sport;
        $this->type = $type ? $type : 'all';
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        switch($this->sport) {
            case 'Basketball':
                $success = $this->dispatchFromArray(DeleteGameBasketballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type]);        
                break;
            case 'Softball':
                $success = $this->dispatchFromArray(DeleteGameSoftballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type]);
                break;
            case 'Football':
                $success = $this->dispatchFromArray(DeleteGameFootballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type]);
                break;
        }
        
        return $success;
        
    }
}

