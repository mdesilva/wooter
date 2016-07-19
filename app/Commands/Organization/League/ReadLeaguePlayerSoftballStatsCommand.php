<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Organization\League\ReadLeaguePlayerSoftballBatterStatsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePlayerSoftballPitcherStatsCommand;

class ReadLeaguePlayerSoftballStatsCommand extends Command implements SelfHandling
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
            'batter' => [],
            'pitcher' => []
        ];
        
        switch($this->type) {
            case 'Batter':
                $stats['batter'] = $this->dispatchFromArray(ReadLeaguePlayerSoftballBatterStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'Pitcher':
                $stats['pitcher'] = $this->dispatchFromArray(ReadLeaguePlayerSoftballPitcherStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
            case 'all':
                $stats['batter'] = $this->dispatchFromArray(ReadLeaguePlayerSoftballBatterStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                $stats['pitcher'] = $this->dispatchFromArray(ReadLeaguePlayerSoftballPitcherStatsCommand::class, ['leagueId' => $this->leagueId, 'request' => $this->request]);
                break;
        }
        
        return $stats;
        
    }
}

