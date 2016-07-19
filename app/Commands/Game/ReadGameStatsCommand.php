<?php

namespace Wooter\Commands\Game;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Game\ReadGameBasketballStatsCommand;
use Wooter\Commands\Game\ReadGameFootballStatsCommand;
use Wooter\Commands\Game\ReadGameSoftballStatsCommand;

class ReadGameStatsCommand extends Command implements SelfHandling
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
    private $request;

    /**
     * Create a new command instance.
     *
     * @param $userId
     * @param $gameId
     * @param $sport
     * @param $type
     *
     * @internal param $user_id
     * @internal param $league_id
     * @internal param $game_id
     */
    public function __construct($userId, $gameId, $request)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->request = $request;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     *
     * @return mixed
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);
        
        if (!$user) {
            throw new UserNotFound();
        }
        
        switch($this->request['sport']) {
            case 'Basketball':
                $stats = $this->dispatchFromArray(ReadGameBasketballStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);        
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(ReadGameSoftballStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(ReadGameFootballStatsCommand::class, ['gameId' => $this->gameId, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}
