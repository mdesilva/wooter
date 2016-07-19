<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class DeleteLeagueVideoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueVideoId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_video_id
     * @param $user_id
     */
    public function __construct($league_video_id, $user_id)
    {

        $this->leagueVideoId = $league_video_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueVideoRepository $leagueVideoRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws LeagueVideoNotFound
     * @throws LeagueNotBelongToUser
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository, VideoRepository $videoRepository)
    {
        $leagueVideo = $leagueVideoRepository->getById($this->leagueVideoId);

        if ( ! $leagueVideo) {
            throw new LeagueVideoNotFound;
        }

        if ($leagueVideo->league->user->id !== $this->userId)
        {
            throw new LeagueNotBelongToUser;
        }


        $video = $videoRepository->getById($leagueVideo->video_id);

        if(file_exists($video->file_path))
        {
            unlink($video->file_path);
        }

        //Detach in records associated with video
        $leagueVideo->team_videos()->detach();
        //Detach in records associated with video
        $leagueVideo->player_videos()->detach();





        if ( ! $leagueVideo->delete())
        {
            throw new DatabaseException('There was an error deleting the league video');
        }

        $video->delete();

        return true;
    }
}
