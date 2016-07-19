<?php

namespace Wooter\Wooter\Transformers\Team;

use Wooter\LeagueOrganization;
use Wooter\RegularStage;
use Wooter\Team;
use Wooter\Wooter\Repositories\Game\GamesRepository;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\Team\DivisionTransformer;

class TeamTransformer extends Transformer
{
    /**
     * @var ImageTransformer
     */
    private $imageTransformer;
    /**
     * @var DivisionTransformer
     */
    private $divisionTransformer;
    /**
     * @var GamesRepository
     */
    private $gamesRepository;
    /**
     * @var PlayerTeamRepository
     */
    private $playerTeamRepository;


    /**
     * @param ImageTransformer     $imageTransformer
     * @param DivisionTransformer  $divisionTransformer
     * @param GamesRepository      $gamesRepository
     * @param PlayerTeamRepository $playerTeamRepository
     */
    public function __construct(ImageTransformer $imageTransformer,
                                DivisionTransformer $divisionTransformer,
                                GamesRepository $gamesRepository,
                                PlayerTeamRepository $playerTeamRepository)
    {

        $this->imageTransformer = $imageTransformer;
        $this->divisionTransformer = $divisionTransformer;
        $this->gamesRepository = $gamesRepository;
        $this->playerTeamRepository = $playerTeamRepository;
    }

    public function transform($team)
    {
        $result =  [
            'id' => $team->id,
            'description' => $team->description,
            'name' => $team->name,
        ];

        $coverPhoto = [];
        if ($team->cover_photo) {
            $coverPhoto = $this->imageTransformer->transform($team->cover_photo);
        }

        $logo = [];
        if ($team->logo) {
            $logo = $this->imageTransformer->transform($team->logo);
        }

        $sport = [];
        if ($team->sport) {
            $sport['id'] = $team->sport->id;
            $sport['name'] = $team->sport->name;
        }

        $captain = [];
        if ($team->captain) {
            $captain['id'] = $team->captain->id;
            $captain['first_name'] = $team->captain->first_name;
            $captain['last_name'] = $team->captain->last_name;
        }
        
        $divisions = [];
        if($team->divisions)
        {
            $divisions = $this->divisionTransformer->transformCollection($team->divisions);
        }

        $players = [];
        $wins = 0;
        $loss = 0;
        $ties = 0;
        $played = 0;

        if (count($team->regular_stages()) > 0) {
            /*$wins = $this->gamesRepository->getWinsByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id);
            $loss = $this->gamesRepository->getLossesByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id);
            $ties = $this->gamesRepository->getDrawsByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id);
            $played = $this->gamesRepository->getGamesPlayedByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id);
            $players = $this->playerTeamRepository->getPlayersByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id)->toArray();
            */
            $wins = $team->stats()->sum('win');
            $loss = $team->stats()->sum('loss');
            $ties = $team->stats()->sum('draw');
            $played = $team->stats()->sum('win') + $team->stats()->sum('loss') + $team->stats()->sum('draw');
            $players = $this->playerTeamRepository->getPlayersByTeamIdAndStage($team->id, RegularStage::class, $team->regular_stages()->first()->id)->toArray();
        }

        return array_merge(
            $result,
            ['wins' => $wins],
            ['loss' => $loss],
            ['ties' => $ties],
            ['played' => $played],
            ['sport' => $sport],
            ['captain' => $captain],
            ['cover_photo' => $coverPhoto],
            ['logo' => $logo],
            ['players' => $players],
            ['divisions' => $divisions]
        );
    }
}

    