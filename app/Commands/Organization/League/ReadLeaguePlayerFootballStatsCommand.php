<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Organization\League\ReadLeaguePlayerFootballQuarterbackStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerFootballReceiverStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerFootballDefenderStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerFootballRusherStatsCommand;

class ReadLeaguePlayerFootballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
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
    public function __construct($type, $leagueId, $request)
    {
        $this->type = $type;
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
        $stats = [
            'quarterback' => [],
            'receiver' => [],
            'defender' => [],
            'rusher' => []
        ];
        
        switch($this->type) {
            case 'Quarterback':
                $stats['quarterback'] = $this->dispatchFromArray(ReadLeaguePlayerFootballQuarterbackStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Receiver':
                $stats['receiver'] = $this->dispatchFromArray(ReadLeaguePlayerFootballReceiverStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Defender':
                $stats['defender'] = $this->dispatchFromArray(ReadLeaguePlayerFootballDefenderStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Rusher':
                $stats['rusher'] = $this->dispatchFromArray(ReadLeaguePlayerFootballRusherStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'all':
                $stats['quarterback'] = $this->dispatchFromArray(ReadLeaguePlayerFootballQuarterbackStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                $stats['receiver'] = $this->dispatchFromArray(ReadLeaguePlayerFootballReceiverStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                $stats['defender'] = $this->dispatchFromArray(ReadLeaguePlayerFootballDefenderStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                $stats['rusher'] = $this->dispatchFromArray(ReadLeaguePlayerFootballRusherStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}
