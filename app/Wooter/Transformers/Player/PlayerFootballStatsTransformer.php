<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballQuarterbackStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballReceiverStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballDefenderStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballRusherStatsTransformer;

class PlayerFootballStatsTransformer extends Transformer
{
    private $quarterbackStatsTransformer;
    private $receiverStatsTransformer;
    private $defenderStatsTransformer;
    private $rusherStatsTransformer;
    public $type;
    public $verbose;
    
    public function __construct(PlayerFootballQuarterbackStatsTransformer $quarterbackStatsTransformer,
                                PlayerFootballReceiverStatsTransformer $receiverStatsTransformer,
                                PlayerFootballDefenderStatsTransformer $defenderStatsTransformer,
                                PlayerFootballRusherStatsTransformer $rusherStatsTransformer) 
    {
        $this->quarterbackStatsTransformer = $quarterbackStatsTransformer;
        $this->receiverStatsTransformer = $receiverStatsTransformer;
        $this->defenderStatsTransformer = $defenderStatsTransformer;
        $this->rusherStatsTransformer = $rusherStatsTransformer;
    }
    
    public function transform($stats)
    {
        $footballStats = [
            'quarterback' => [],
            'receiver' => [],
            'defender' => [],
            'rusher' => []
        ];
        
        switch($this->type) {
            case 'Quarterback':
                $this->quarterbackStatsTransformer->verbose = $this->verbose;
                $footballStats['quarterback'] = $this->quarterbackStatsTransformer->transformCollection($stats['quarterback']);
                break;
            case 'Receiver':
                $this->receiverStatsTransformer->verbose = $this->verbose;
                $footballStats['receiver'] = $this->receiverStatsTransformer->transformCollection($stats['receiver']);
                break;
            case 'Defender':
                $this->defenderStatsTransformer->verbose = $this->verbose;
                $footballStats['defender'] = $this->defenderStatsTransformer->transformCollection($stats['defender']);
                break;
            case 'Rusher':
                $this->rusherStatsTransformer->verbose = $this->verbose;
                $footballStats['rusher'] = $this->rusherStatsTransformer->transformCollection($stats['rusher']);
                break;
            case 'all':
                $this->quarterbackStatsTransformer->verbose = $this->verbose;
                $this->receiverStatsTransformer->verbose = $this->verbose;
                $this->defenderStatsTransformer->verbose = $this->verbose;
                $this->rusherStatsTransformer->verbose = $this->verbose;
                $footballStats['quarterback'] = $this->quarterbackStatsTransformer->transformCollection($stats['quarterback']);
                $footballStats['receiver'] = $this->receiverStatsTransformer->transformCollection($stats['receiver']);
                $footballStats['defender'] = $this->defenderStatsTransformer->transformCollection($stats['defender']);
                $footballStats['rusher'] = $this->rusherStatsTransformer->transformCollection($stats['rusher']);
                break;
        }
        
        return $footballStats;
    }
}

