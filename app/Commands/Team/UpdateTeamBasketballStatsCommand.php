<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\Team\TeamBasketballStatsRepository;

class UpdateTeamBasketballStatsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    
    /**
    * @var
    */
    private $teamId;
    
    /**
     * @var
     */
    private $gameId;
    
    /**
     * @var
     */
    private $firstQuarterScore;
    
    /**
     * @var
     */
    private $secondQuarterScore;
    
    /**
     * @var
     */
    private $thirdQuarterScore;
    
    /**
     * @var
     */
    private $fourthQuarterScore;
    
    /**
     * @var
     */
    private $finalScore;
    
    /**
     * @var
     */
    private $win;
    
    /**
     * @var
     */
    private $loss;
    
    /**
     * @var
     */
    private $draw;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($request, $teamId, $gameId)
    {
        $this->teamId = $teamId;
        $this->gameId = $gameId;
        $this->firstQuarterScore = 0; //$request['first_quarter_score'];
        $this->secondQuarterScore = 0; //$request['second_quarter_score'];
        $this->thirdQuarterScore = 0; //$request['third_quarter_score'];
        $this->fourthQuarterScore = 0; //$request['fourth_quarter_score'];
        $this->finalScore = $request['final_score'];
        $this->win = $request['win'];
        $this->loss = $request['loss'];
        $this->draw = $request['draw'];
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(TeamBasketballStatsRepository $teamBasketballStatsRepository)
    {
        
        $teamStats = $teamBasketballStatsRepository->getByTeamAndGameId($this->teamId, $this->gameId);
        $teamStats->first_quarter_score = $this->firstQuarterScore;
        $teamStats->second_quarter_score = $this->secondQuarterScore;
        $teamStats->third_quarter_score = $this->thirdQuarterScore;
        $teamStats->fourth_quarter_score = $this->fourthQuarterScore;
        $teamStats->final_score = $this->finalScore;
        $teamStats->win = $this->win;
        $teamStats->loss = $this->loss;
        $teamStats->draw = $this->draw;
        $teamBasketballStatsRepository->update($teamStats);
        
        return $teamStats;
    }
}

