<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballBatterStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballPitcherStatsTransformer;

class PlayerSoftballStatsTransformer extends Transformer
{
    private $batterStatsTransformer;
    private $pitcherStatsTransformer;
    public $type;
    public $verbose;
    
    public function __construct(PlayerSoftballBatterStatsTransformer $batterStatsTransformer,
                                PlayerSoftballPitcherStatsTransformer $pitcherStatsTransformer) 
    {
        $this->batterStatsTransformer = $batterStatsTransformer;
        $this->pitcherStatsTransformer = $pitcherStatsTransformer;
    }
    
    public function transform($stats)
    {
        $softballStats = [
            'batter' => [],
            'pitcher' => []
        ];
        
        switch($this->type) {
            case 'Batter':
                $this->batterStatsTransformer->verbose = $this->verbose;
                $softballStats['batter'] = $this->batterStatsTransformer->transformCollection($stats['batter']);
                break;
            case 'Pitcher':
                $this->pitcherStatsTransformer->verbose = $this->verbose;
                $softballStats['pitcher'] = $this->pitcherStatsTransformer->transformCollection($stats['pitcher']);
                break;
            case 'all':
                $this->batterStatsTransformer->verbose = $this->verbose;
                $this->pitcherStatsTransformer->vebrose = $this->verbose;
                $softballStats['batter'] = $this->batterStatsTransformer->transformCollection($stats['batter']);
                $softballStats['pitcher'] = $this->pitcherStatsTransformer->transformCollection($stats['pitcher']);
        }
        
        return $softballStats;
    }
}

