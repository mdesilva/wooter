<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Organization\League\ReadLeagueTeamBasketballStatsCommand;
use Wooter\Commands\League\ReadLeagueTeamSoftballStatsCommand;
use Wooter\Commands\League\ReadLeagueTeamFootballStatsCommand;

class ReadLeagueTeamStatsCommand extends Command implements SelfHandling
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
    public function __construct($userId, $sport, $leagueId, $request)
    {
        $this->userId = $userId;
        $this->sport = $sport;
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
    public function handle()
    {
        switch($this->sport) {
            case 'Basketball':
                $stats = $this->dispatchFromArray(ReadLeagueTeamBasketballStatsCommand::class, ['leagueId' => $this->leagueId, 'params' => $this->request]);
                break;
            case 'Softball':
                $stats = $this->dispatchFromArray(ReadLeagueTeamSoftballStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Football':
                $stats = $this->dispatchFromArray(ReadLeagueTeamFootballStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}

