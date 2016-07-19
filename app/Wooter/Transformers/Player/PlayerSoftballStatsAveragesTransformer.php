<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballBatterStatsAveragesTransformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballPitcherStatsAveragesTransformer;

class PlayerSoftballStatsAveragesTransformer extends Transformer
{
    private $batterAveragesTransformer;
    private $pitcherAveragesTransformer;
    public $all;
    public $type;
    public $stat_name;
    
    public function __construct(PlayerSoftballBatterStatsAveragesTransformer $batterAveragesTransformer,
                                PlayerSoftballPitcherStatsAveragesTransformer $pitcherAveragesTransformer) 
    {
        $this->batterAveragesTransformer = $batterAveragesTransformer;
        $this->pitcherAveragesTransformer = $pitcherAveragesTransformer;
    }
    
    public function transform($stats)
    {
        $softballStats = [
            
        ];
        
        switch($this->type) {
            case 'Batter':
            case 'batter':
                $this->batterAveragesTransformer->all = $this->all;
                $this->batterAveragesTransformer->stat_name = $this->stat_name;
                $softballStats = $this->batterAveragesTransformer->transform($stats);
                break;
            case 'Pitcher':
            case 'pitcher':
                $this->pitcherAveragesTransformer->all = $this->all;
                $this->pitcherAveragesTransformer->stat_name = $this->stat_name;
                $softballStats = $this->pitcherAveragesTransformer->transform($stats);
                break;
            case 'all':
                $this->batterAveragesTransformer->all = $this->all;
                $this->batterAveragesTransformer->stat_name = $this->stat_name;
                $softballStats['batter'] = $this->batterAveragesTransformer->transform($stats);
                $this->pitcherAveragesTransformer->all = $this->all;
                $this->pitcherAveragesTransformer->stat_name = $this->stat_name;
                $softballStats['pitcher'] = $this->pitcherAveragesTransformer->transform($stats);
        }
        
        return $softballStats;
    }
}

