<?php

namespace Wooter\Commands\Stage\Regular;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;
use Wooter\RegularStage;

class CreateRegularStageCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $user_id;
    
    /**
     * @var
     */
    private $competition_id;
    
    /**
     * @var
     */
    private $competition_type;
    
    /**
     * @var
     */
    private $rule_id;
    
    /**
     * @var
     */
    private $rule_type;
    
    /**
     * @var
     */
    private $starts_at;
    
    /**
     * @var
     */
    private $ends_at;
    
    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_id
     */
    public function __construct($user_id, $competition_id, $competition_type, $rule_id, $rule_type, $starts_at, $ends_at)
    {
        $this->user_id = $user_id;
        $this->competition_id = $competition_id;
        $this->competition_type = $competition_type;
        $this->rule_id = $rule_id;
        $this->rule_type = $rule_type;
        $this->starts_at = $starts_at;
        $this->ends_at = $ends_at;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository                  $userRepository
     * @param PlayerBasketballStatsRepository $statsRepository
     *
     * @throws UserNotFound
     */
    public function handle(RegularStageRepository $regularsRepository)
    {
        
        $regular = new RegularStage();
        
        $regular->competition_id = $this->competition_id;
        $regular->competition_type = $this->competition_type;
        $regular->rule_id = $this->rule_id;
        $regular->rule_type = $this->rule_type;
        $regular->starts_at = $this->starts_at;
        $regular->ends_at = $this->ends_at;
        
        $regularsRepository->create($regular);
        
        return $regular;
    }
}

