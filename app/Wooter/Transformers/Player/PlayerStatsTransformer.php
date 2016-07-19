<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerBasketballStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballStatsTransformer;

class PlayerStatsTransformer extends Transformer
{
    private $basketballStatsTransformer;
    private $softballStatsTransformer;
    private $footballStatsTransformer;
    public $sport;
    public $type;
    public $verbose;
    
    public function __construct(PlayerBasketballStatsTransformer $basketballStatsTransformer,
                                PlayerSoftballStatsTransformer $softballStatsTransformer,
                                PlayerFootballStatsTransformer $footballStatsTransformer) 
    {
        $this->basketballStatsTransformer = $basketballStatsTransformer;
        $this->softballStatsTransformer = $softballStatsTransformer;
        $this->footballStatsTransformer = $footballStatsTransformer;
    }
    
    public function transform($stats)
    {
        $playerStats = [];
        switch($this->sport) {
            case 'Basketball':
                $this->basketballStatsTransformer->verbose = $this->verbose;
                $playerStats['all'] = $this->basketballStatsTransformer->transformCollection($stats['basketball']);
                break;
            case 'Softball':
                $this->softballStatsTransformer->verbose = $this->verbose;
                $this->softballStatsTransformer->type = $this->type;
                $playerStats = $this->softballStatsTransformer->transform($stats);
                break;
            case 'Football':
                $this->footballStatsTransformer->verbose = $this->verbose;
                $this->footballStatsTransformer->type = $this->type;
                $playerStats = $this->footballStatsTransformer->transform($stats);
                break;
        }
        
        return $playerStats;
    }
}

