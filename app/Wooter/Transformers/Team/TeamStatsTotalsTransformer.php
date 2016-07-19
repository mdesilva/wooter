<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Team\TeamBasketballStatsTotalsTransformer;
use Wooter\Wooter\Transformers\Team\TeamSoftballStatsTotalsTransformer;
use Wooter\Wooter\Transformers\Team\TeamFootballStatsTotalsTransformer;

class TeamStatsTotalsTransformer extends Transformer
{
    private $basketballStatsTransformer;
    private $softballStatsTransformer;
    private $footballStatsTransformer;
    public $sport;
    public $type;
    public $collection;
    public $bulk;
    public $all;
    
    public function __construct(TeamBasketballStatsTotalsTransformer $basketballStatsTransformer,
                                TeamSoftballStatsTotalsTransformer $softballStatsTransformer,
                                TeamFootballStatsTotalsTransformer $footballStatsTransformer) 
    {
        $this->basketballStatsTransformer = $basketballStatsTransformer;
        $this->softballStatsTransformer = $softballStatsTransformer;
        $this->footballStatsTransformer = $footballStatsTransformer;
    }
    
    public function transform($stats)
    {
        $data = [];
        
        switch($this->sport) {
            case 'Basketball':
                $transformer = $this->basketballStatsTransformer;
                break;
            case 'Softball':
                $stats = $this->softballStatsTransformer;
                break;
            case 'Football':
                $stats = $this->footballStatsTransformer;
                break;
        }
        
        $leadingTeamId = $this->all->first()->team_id;
        $leadingTeamStats = $this->all->where('team_id', $leadingTeamId);
        $transformer->leadingTeamStats = $leadingTeamStats;
        switch ($this->bulk) {
            case 'true':
                $data = $transformer->transform($stats);
                break;
            case 'false':
                $uniqueIds = [];
                $allIds = $stats->lists('team_id');
                foreach ($allIds as $id) {
                    $uniqueIds[$id] = $id;
                }
                
                foreach ($uniqueIds as $id) {
                    $teamStats = $stats->where('team_id', $id);
                    $team = $teamStats->first()->team;
                    $team_logo = $team->logo ? $team->logo->file_path : null;
                    $team_logo_thumbnail = $team->logo ? $team->logo->thumbnail_path : null;
                    $data[] = [
                        'stats' => $transformer->transform($teamStats),
                        'team_id' => $team->id,
                        'team_name' => $team->name,
                        'team_logo' => $team_logo,
                        'team_logo_thumbnail' => $team_logo_thumbnail,
                        'team_divisions' => $team->divisions->toArray()
                    ];
                }
        }
        
        return $data;
    }
}
