<?php

namespace Wooter\Commands\Organization\League;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateVideoCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePublishVideosCommand;
use Wooter\LeagueVideo;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueVideoCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $leagueId;
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
     * @var
     */
    private $resumableChunkNumber;
    /**
     * @var
     */
    private $resumableChunkSize;
    /**
     * @var
     */
    private $resumableCurrentChunkSize;
    /**
     * @var
     */
    private $resumableTotalSize;
    /**
     * @var
     */
    private $resumableType;
    /**
     * @var
     */
    private $resumableIdentifier;
    /**
     * @var
     */
    private $resumableFilename;
    /**
     * @var
     */
    private $resumableRelativePath;
    /**
     * @var
     */
    private $resumableTotalChunks;

    /** Vars for league publish video functions */
    /**
     * @var array
     */
    private $videos = array();

    /**
     * @var
     */
    private $players;

    /**
     * @var
     */
    private $teams;

    /**
     * @var
     */
    private $leaguePublishVideoFlag;



    /**
     * Create a new command instance.
     *
     * @param              $league_id
     * @param              $user_id
     * @param UploadedFile $video
     *
     * @param null         $description
     */
    public function __construct($league_id, $user_id, $video = null, $description = null,
                                $resumableChunkNumber = null,
                                $resumableChunkSize = null,
                                $resumableCurrentChunkSize = null,
                                $resumableTotalSize = null,
                                $resumableType = null,
                                $resumableIdentifier = null,
                                $resumableFilename = null,
                                $resumableRelativePath = null,
                                $resumableTotalChunks = null,
                                $videos = null,
                                $players = null,
                                $teams = null,
                                $leaguePublishVideoFlag = false
                                )
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->video = $video;
        $this->description = $description;
        $this->resumableChunkNumber = $resumableChunkNumber;
        $this->resumableChunkSize = $resumableChunkSize;
        $this->resumableCurrentChunkSize = $resumableCurrentChunkSize;
        $this->resumableTotalSize = $resumableTotalSize;
        $this->resumableType = $resumableType;
        $this->resumableIdentifier = $resumableIdentifier;
        $this->resumableFilename = $resumableFilename;
        $this->resumableRelativePath = $resumableRelativePath;
        $this->resumableTotalChunks = $resumableTotalChunks;
        $this->videos = $videos;
        $this->players = $players;
        $this->teams = $teams;
        $this->leaguePublishVideoFlag = $leaguePublishVideoFlag;
    }

    /**
     * Execute the command.
     *
     * @param LeagueVideoRepository $leagueVideoRepository
     *
     * @param UserRepository        $userRepository
     * @param LeagueRepository      $leagueRepository
     *
     * @return LeagueVideo
     * @throws Exception
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     * @internal param LeagueRepository $leagueRepository
     */
    public function handle(LeagueVideoRepository $leagueVideoRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository)
    {

        $league = $leagueRepository->getById($this->leagueId);
        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if($this->leaguePublishVideoFlag)
        {
            $this->dispatchFromArray(UpdateLeaguePublishVideosCommand::class, ['videos' => $this->videos,'teams' => $this->teams, 'players' => $this->players, 'user_id' => $this->userId]);

        }elseif(isset($this->resumableIdentifier) && trim($this->resumableIdentifier)!='')
        {

            // writing video chunk in leagues temporary directory
            $video = $this->dispatchFromArray(CreateVideoCommand::class, [
                'video' => $this->video,'organizationFolder' =>
                'organization_'.$league->organization_id,
                'folder' => 'league_'.$this->leagueId,
                'description' => $this->description,
                'prefix' => 'league_video_',
                'chunk' => true,
                'chunkIdentifier' => $this->resumableIdentifier,
                'chunkNumber' => $this->resumableChunkNumber,
                'chunkName' => $this->resumableFilename,
                'totalFileSize' => $this->resumableTotalSize,
                'totalChunks' => $this->resumableTotalChunks
            ]);

            if($video->complete == "success")
            {
                $leagueVideo = new LeagueVideo;
                $leagueVideo->league_id = $this->leagueId;
                $leagueVideo->video_id = $video->id;

                if (! $leagueVideoRepository->create($leagueVideo)) {
                    throw new Exception('League Video could not be saved');
                }
                $leagueVideo->complete = $video->complete;
                return $leagueVideo;
            }

            return $video;

        }else{

             if(is_array($this->video))
             {
                 $videos = array();

                 foreach($this->video as $video)
                 {
                     $leagueVideo = DB::transaction(function () use ($leagueVideoRepository, $video) {

                         $video = $this->dispatchFromArray(CreateVideoCommand::class, ['video' => $video, 'description' => $this->description, 'prefix' => 'league_video_']);

                         $leagueVideo = new LeagueVideo;
                         $leagueVideo->league_id = $this->leagueId;
                         $leagueVideo->video_id = $video->id;

                         if (! $leagueVideoRepository->create($leagueVideo)) {
                             throw new Exception('League Video could not be saved');
                         }


                         return $leagueVideo;

                     });

                     $videos[] = $leagueVideo;
                 }

                 return $videos;
             } else {

                 $leagueVideo = DB::transaction(function () use ($leagueVideoRepository) {

                     $video = $this->dispatchFromArray(CreateVideoCommand::class, ['video' => $this->video, 'description' => $this->description, 'prefix' => 'league_video_']);

                     $leagueVideo = new LeagueVideo;
                     $leagueVideo->league_id = $this->leagueId;
                     $leagueVideo->video_id = $video->id;

                     if (! $leagueVideoRepository->create($leagueVideo)) {
                         throw new Exception('League Video could not be saved');
                     }

                     return $leagueVideo;
                 });

                 return $leagueVideo;
             }

        }
    }
}
