<?php

namespace Wooter\Commands\Likes;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\CountValidator\Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Image;
use Wooter\LeaguePermission;
use Wooter\Like;
use Wooter\Video;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\UserNotMemberException;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\LikeRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePermissionRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class LikeCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $likedItemId;
    /**
     * @var
     */
    private $likedItemType;
    /**
     * @var
     */
    private $like;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $liked_item_id
     * @param $liked_item_type
     * @param $like
     */
    public function __construct($user_id, $liked_item_id, $liked_item_type, $like)
    {
        $this->userId = $user_id;
        $this->likedItemId = $liked_item_id;
        $this->likedItemType = $liked_item_type;
        $this->like = $like;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return void|Like
     * @throws ImageNotFound
     * @throws LeaguePhotoNotFound
     * @throws UserNotFound
     * @throws VideoNotFound
     */
    public function handle(UserRepository $userRepository)
    {


        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        switch ($this->likedItemType) {
            case Image::class:
                /**
                 * @var $imageRepository ImageRepository
                 */
                $imageRepository = app(ImageRepository::class);

                $image = $imageRepository->getById($this->likedItemId);

                if ( ! $image) {
                    throw new ImageNotFound;
                }

                /**
                 * @var $leaguePhotoRepository LeaguePhotoRepository
                 */
                $leaguePhotoRepository = app(LeaguePhotoRepository::class);
                $leaguePhoto = $leaguePhotoRepository->getByImageId($this->likedItemId);

                if ( ! $leaguePhoto) {
                    throw new LeaguePhotoNotFound;
                }

                $this->checkPermission($leaguePhoto->league);

                return $this->updateLike();

            case Video::class:
                /**
                 * @var $videoRepository VideoRepository
                 */
                $videoRepository = app(VideoRepository::class);

                $video = $videoRepository->getById($this->likedItemId);

                if ( ! $video) {
                    throw new VideoNotFound;
                }

                /**
                 * @var $leagueVideoRepository LeagueVideoRepository
                 */
                $leagueVideoRepository = app(LeagueVideoRepository::class);
                $leagueVideo = $leagueVideoRepository->getByVideoId($this->likedItemId);

                if ( ! $leagueVideo) {
                    throw new LeaguePhotoNotFound;
                }

                $this->checkPermission($leagueVideo->league);

                return $this->updateLike();
        }

        return false;
    }

    private function checkPermission($league)
    {
        /**
         * @var $leaguePermissionRepository LeaguePermissionRepository
         */
        $leaguePermissionRepository = app(LeaguePermissionRepository::class);
        /**
         * @var $playerLeagueRepository PlayerLeagueRepository
         */
        $playerLeagueRepository = app(PlayerLeagueRepository::class);

        $leaguePermission = $leaguePermissionRepository->getByLeagueIdAndType($league->id, LeaguePermission::TYPE_LIKE);

        if ($leaguePermission && $leaguePermission->permission === LeaguePermission::PERMISSION_ONLY_MEMBERS) {

            $player = $playerLeagueRepository->getByPlayerAndLeagueId($this->userId, $league->id);

            if ( ! $player &&
                $league->user->id !== $this->userId ) { // Is owner - Owner can like

                throw new UserNotMemberException;
            }
        }
    }

    private function updateLike()
    {
        /**
         * @var $likeRepository LikeRepository
         */
        $likeRepository = app(LikeRepository::class);

        $like = $likeRepository->getByUserAndItem($this->userId, $this->likedItemId, $this->likedItemType);

        if ( ! $like) {
            $like = new Like;
            $like->user_id = $this->userId;
            $like->liked_item_id = $this->likedItemId;
            $like->liked_item_type = $this->likedItemType;
        }

        $like->liked = $this->like;

        $likeRepository->update($like);

        return $like;
    }
}
