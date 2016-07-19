<?php

namespace Wooter\Commands\Comment;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\CountValidator\Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Comment;
use Wooter\Image;
use Wooter\LeaguePermission;
use Wooter\Like;
use Wooter\Video;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\UserNotMemberException;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Repositories\CommentRepository;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\LikeRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePermissionRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class CreateCommentCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $commentedItemId;
    /**
     * @var
     */
    private $commentedItemType;
    /**
     * @var
     */
    private $comment;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $commented_item_id
     * @param $commented_item_type
     * @param $comment
     */
    public function __construct($user_id, $commented_item_id, $commented_item_type, $comment)
    {
        $this->userId = $user_id;
        $this->commentedItemId = $commented_item_id;
        $this->commentedItemType = $commented_item_type;
        $this->comment = $comment;
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

        switch ($this->commentedItemType) {
            case Image::class:
                /**
                 * @var $imageRepository ImageRepository
                 */
                $imageRepository = app(ImageRepository::class);

                $image = $imageRepository->getById($this->commentedItemId);

                if ( ! $image) {
                    throw new ImageNotFound;
                }

                /**
                 * @var $leaguePhotoRepository LeaguePhotoRepository
                 */
                $leaguePhotoRepository = app(LeaguePhotoRepository::class);
                $leaguePhoto = $leaguePhotoRepository->getByImageId($this->commentedItemId);

                if ( ! $leaguePhoto) {
                    throw new LeaguePhotoNotFound;
                }

                $this->checkPermission($leaguePhoto->league);

                return $this->createComment();

            case Video::class:
                /**
                 * @var $videoRepository VideoRepository
                 */
                $videoRepository = app(VideoRepository::class);

                $video = $videoRepository->getById($this->commentedItemId);

                if ( ! $video) {
                    throw new VideoNotFound;
                }

                /**
                 * @var $leagueVideoRepository LeagueVideoRepository
                 */
                $leagueVideoRepository = app(LeagueVideoRepository::class);
                $leagueVideo = $leagueVideoRepository->getByVideoId($this->commentedItemId);

                if ( ! $leagueVideo) {
                    throw new LeaguePhotoNotFound;
                }

                $this->checkPermission($leagueVideo->league);

                return $this->createComment();
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

        $leaguePermission = $leaguePermissionRepository->getByLeagueIdAndType($league->id, LeaguePermission::TYPE_COMMENT);

        // check if is owner and return true

        if ($leaguePermission && $leaguePermission->permission === LeaguePermission::PERMISSION_ONLY_MEMBERS) {

            $player = $playerLeagueRepository->getByPlayerAndLeagueId($this->userId, $league->id);

            if ( ! $player) {
                throw new UserNotMemberException;
            }
        }
    }

    private function createComment()
    {
        /**
         * @var $commentRepository CommentRepository
         */
        $commentRepository = app(CommentRepository::class);

        $comment = new Comment;
        $comment->user_id = $this->userId;
        $comment->commented_item_id = $this->commentedItemId;
        $comment->commented_item_type = $this->commentedItemType;
        $comment->comment = $this->comment;

        $commentRepository->create($comment);

        return $comment;
    }
}
