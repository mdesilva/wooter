<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballQuarterbackStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballReceiverStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballDefenderStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballRusherbackStatsAveragesTransformer;

class PlayerFootballStatsAveragesTransformer extends Transformer
{
    private $quarterbackAveragesTransformer;
    private $receiverAveragesTransformer;
    private $defenderAveragesTransformer;
    private $rusherAveragesTransformer;
    public $all;
    public $type;
    public $stat_name;
    
    public function __construct(PlayerFootballQuarterbackStatsAveragesTransformer $quarterbackAveragesTransformer,
                                PlayerFootballReceiverStatsAveragesTransformer $receiverAveragesTransformer,
                                PlayerFootballDefenderStatsAveragesTransformer $defenderAveragesTransformer,
                                PlayerFootballRusherStatsAveragesTransformer $rusherAveragesTransformer) 
    {
        $this->quarterbackAveragesTransformer = $quarterbackAveragesTransformer;
        $this->receiverAveragesTransformer = $receiverAveragesTransformer;
        $this->defenderAveragesTransformer = $defenderAveragesTransformer;
        $this->rusherAveragesTransformer = $rusherAveragesTransformer;
    }
    
    public function transform($stats)
    {
        $footballStats = [
            
        ];
        
        switch($this->type) {
            case 'Quarterback':
            case 'quarterback':
                $this->quarterbackAveragesTransformer->all = $this->all;
                $this->quarterbackAveragesTransformer->stat_name = $this->stat_name;
                $footballStats = $this->quarterbackAveragesTransformer->transform($stats);
                break;
            case 'Receiver':
            case 'receiver':
                $this->receiverAveragesTransformer->all = $this->all;
                $this->receiverAveragesTransformer->stat_name = $this->stat_name;
                $footballStats = $this->receiverAveragesTransformer->transform($stats);
                break;
            case 'Defender':
            case 'defender':
                $this->defenderAveragesTransformer->all = $this->all;
                $this->defenderAveragesTransformer->stat_name = $this->stat_name;
                $footballStats = $this->defenderAveragesTransformer->transform($stats);
                break;
            case 'Rusher':
            case 'rusher':
                $this->rusherAveragesTransformer->all = $this->all;
                $this->rusherAveragesTransformer->stat_name = $this->stat_name;
                $footballStats = $this->rusherAveragesTransformer->transform($stats);
                break;
        }
        
        return $footballStats;
    }
}

