<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerBasketballStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballStatsAveragesTransformer;

class PlayerStatsAveragesTransformer extends Transformer
{
    private $basketballAveragesTransformer;
    private $softballAveragesTransformer;
    private $footballAveragesTransformer;
    public $sport;
    public $type;
    public $all;
    public $stat_name;
    
    public function __construct(PlayerBasketballStatsAveragesTransformer $basketballAveragesTransformer,
                                PlayerSoftballStatsAveragesTransformer $softballAveragesTransformer,
                                PlayerFootballStatsAveragesTransformer $footballAveragesTransformer) 
    {
        $this->basketballAveragesTransformer = $basketballAveragesTransformer;
        $this->softballAveragesTransformer = $softballAveragesTransformer;
        $this->footballAveragesTransformer = $footballAveragesTransformer;
    }
    
    public function transform($averages)
    {
        $playerAverages = [];
        switch($this->sport) {
            case 'Basketball':
                $this->basketballAveragesTransformer->all = $this->all;
                $this->basketballAveragesTransformer->stat_name = $this->stat_name;
                $this->basketballAveragesTransformer->type = $this->type;
                $playerAverages = $this->basketballAveragesTransformer->transform($averages);
                break;
            case 'Softball':
                $this->softballAveragesTransformer->all = $this->all;
                $this->softballAveragesTransformer->stat_name = $this->stat_name;
                $this->softballAveragesTransformer->type = $this->type;
                $playerAverages = $this->softballAveragesTransformer->transform($averages);
                break;
            case 'Football':
                $this->footballAveragesTransformer->all = $this->all;
                $this->footballAveragesTransformer->stat_name = $this->stat_name;
                $this->footballAveragesTransformer->type = $this->type;
                $playerAverages = $this->footballAveragesTransformer->transform($averages);
                break;
        }
        
        return $playerAverages;
    }
}

