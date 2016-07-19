<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;

class ReadLeagueVideoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueVideoId;

    /**
     * Create a new command instance.
     *
     * @param $league_video_id
     */
    public function __construct($league_video_id)
    {
        $this->leagueVideoId = $league_video_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueVideoRepository $leagueVideoRepository
     *
     * @return
     * @throws LeagueVideoNotFound
     * @throws NotPermissionException
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository)
    {
        $leagueVideo = $leagueVideoRepository->getById($this->leagueVideoId);

        if ( ! $leagueVideo) {
            throw new LeagueVideoNotFound;
        }

        return $leagueVideo;
    }
}
