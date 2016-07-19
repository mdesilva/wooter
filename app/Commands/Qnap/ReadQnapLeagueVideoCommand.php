<?php

namespace Wooter\Commands\Qnap;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Qnap\QnapLeagueVideoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;

class ReadQnapLeagueVideoCommand extends Command implements SelfHandling
{

/*    private $videos;*/
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(/*$video*/)
    {
        //$this->videos = $video;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository)
    {


       return $leagueVideoRepository->readAllQnapVideos();
    }
}
