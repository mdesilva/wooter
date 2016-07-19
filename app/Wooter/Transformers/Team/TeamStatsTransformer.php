<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Team\TeamBasketballStatsTransformer;
use Wooter\Wooter\Transformers\Team\TeamSoftballStatsTransformer;
use Wooter\Wooter\Transformers\Team\TeamFootballStatsTransformer;

class TeamStatsTransformer extends Transformer
{
    private $basketballStatsTransformer;
    private $softballStatsTransformer;
    private $footballStatsTransformer;
    public $sport;
    public $type;
    public $collection;
    
    public function __construct(TeamBasketballStatsTransformer $basketballStatsTransformer,
                                TeamSoftballStatsTransformer $softballStatsTransformer,
                                TeamFootballStatsTransformer $footballStatsTransformer) 
    {
        $this->basketballStatsTransformer = $basketballStatsTransformer;
        $this->softballStatsTransformer = $softballStatsTransformer;
        $this->footballStatsTransformer = $footballStatsTransformer;
    }
    
    public function transform($stats)
    {
        switch($this->sport) {
            case 'Basketball':
                switch($this->collection){
                    case true:
                        $stats = $this->basketballStatsTransformer->transformCollection($stats);
                        break;
                    case false:
                        $stats = $this->basketballStatsTransformer->transform($stats);
                        break;
                }
                break;
            case 'Softball':
                $stats = $this->softballStatsTransformer->transformCollection($stats);
                break;
            case 'Football':
                $stats = $this->footballStatsTransformer->transformCollection($stats);
                break;
        }
        
        return $stats;
    }
}

