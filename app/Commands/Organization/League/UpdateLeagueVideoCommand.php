<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\UpdateVideoCommand;
use Wooter\Wooter\Exceptions\FileSystemException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;

class UpdateLeagueVideoCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $leagueVideoId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $video;
    /**
     * @var null
     */
    private $description;


    /**
     * Create a new command instance.
     *
     * @param                   $league_video_id
     * @param                   $user_id
     * @param UploadedFile      $video
     * @param null              $description
     */
    public function __construct($league_video_id, $user_id, $video, $description = null)
    {
        $this->leagueVideoIid = $league_video_id;
        $this->userId = $user_id;
        $this->video = $video;
        $this->description = $description;
    }

    /**
     * Execute the command.
     *
     * @param LeagueVideoRepository $leagueVideoRepository
     *
     * @return
     * @throws Exception
     * @throws FileSystemException
     * @throws LeagueNotBelongToUser
     * @throws LeagueVideoNotFound
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository)
    {
        $leagueVideo = $leagueVideoRepository->getById($this->leagueVideoId);

        if ( ! $leagueVideo)
        {
            throw new LeagueVideoNotFound;
        }

        if ($leagueVideo->league->organization->user->id !== $this->userId) {
            throw new LeagueNotBelongToUser;
        }

        $this->dispatchFromArray(UpdateVideoCommand::class, ['video' => $this->video, 'description' => $this->description, 'prefix' => 'league_video_']);

        return $leagueVideo->fresh();
    }
}
