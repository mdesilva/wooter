<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Organization\League\ReadLeaguePlayerBasketballStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerFootballStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerSoftballStatsCommand;

class ReadLeaguePlayerStatsCommand extends Command implements SelfHandling
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
    private $type;
    
    /**
     * @var
     */
    private $leagueId;
    
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
    public function __construct($userId, $sport, $type, $leagueId, $request)
    {
        $this->userId = $userId;
        $this->sport = $sport;
        $this->type = $type ? $type : 'all';
        $this->leagueId = $leagueId;
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
                $stats = $this->dispatchFromArray(ReadLeaguePlayerBasketballStatsCommand::class, ['type' => $this->type, 'leagueId' => $this->leagueId, 'request' => $this->request]);        
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(ReadLeaguePlayerSoftballStatsCommand::class, ['type' => $this->type, 'leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(ReadLeaguePlayerFootballStatsCommand::class, ['type' => $this->type, 'leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}
