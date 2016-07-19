<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\CreateGameBasketballStatsCommand;
use Wooter\Commands\Game\CreateGameBasketballStatsByUploadCommand;
use Wooter\Commands\Game\CreateGameFootballStatsCommand;
use Wooter\Commands\Game\CreateGameSoftballStatsCommand;

class CreateGameStatsCommand extends Command implements SelfHandling
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
    private $method;
    
    /**
     * @var
     */
    private $sport;
    
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
    public function __construct($userId, $gameId, $method, $sport, $type, $request)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->method = $method;
        $this->sport = $sport;
        $this->type = $type ? $type : 'all';
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
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        
        switch($this->sport) {
            case 'Basketball':
                switch($this->method) {
                    case 'form':
                        $stats = $this->dispatchFromArray(CreateGameBasketballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type, 'request' => $this->request]);                               
                        break;
                    case 'upload':
                        $stats = $this->dispatchFromArray(CreateGameBasketballStatsByUploadCommand::class, ['gameId' => $this->gameId, 'type' => $this->type, 'request' => $this->request]);
                        break;
                }
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(CreateGameSoftballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type, 'request' => $this->request]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(CreateGameFootballStatsCommand::class, ['gameId' => $this->gameId, 'type' => $this->type, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}

