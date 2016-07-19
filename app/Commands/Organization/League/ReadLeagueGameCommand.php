<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeagueGameCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
    /*
     * @var
     */
    private $league_id;
    
    /*
     * @var
     */
    private $game_id;
    

    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $league_id, $game_id)
    { 
        /*ob_start();
        var_dump('two');
        $res = ob_get_clean();
        file_put_contents('newfile.txt', $res);*/
        $this->userId    = $userId;
        $this->league_id = $league_id;
        $this->game_id = $game_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository,
                           GamesRepository $gamesRepository)
    {
        /*ob_start();
        var_dump('three');
        $res = ob_get_clean();
        file_put_contents('newfile.txt', $res);*/
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        return $gamesRepository->getById($this->game_id);
        
    }
}
