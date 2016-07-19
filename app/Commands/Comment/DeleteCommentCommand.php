<?php

namespace Wooter\Commands\Comment;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Image;
use Wooter\Like;
use Wooter\Video;
use Wooter\Wooter\Exceptions\CommentNotFound;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Repositories\CommentRepository;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class DeleteCommentCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $commentId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $comment_id
     */
    public function __construct($user_id, $comment_id)
    {
        $this->userId = $user_id;
        $this->commentId = $comment_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository    $userRepository
     *
     * @param CommentRepository $commentRepository
     *
     * @return void|Like
     * @throws CommentNotFound
     * @throws ImageNotFound
     * @throws LeaguePhotoNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     * @throws VideoNotFound
     */
    public function handle(UserRepository $userRepository, CommentRepository $commentRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $comment = $commentRepository->getById($this->commentId);

        if ( ! $comment) {
            throw new CommentNotFound;
        }

        $isOwner = false;

        switch ($comment->commented_item_type) {
            case Image::class:
                /**
                 * @var $imageRepository ImageRepository
                 */
                $imageRepository = app(ImageRepository::class);

                $image = $imageRepository->getById($comment->commented_item_id);

                if ( ! $image) {
                    throw new ImageNotFound;
                }

                /**
                 * @var $leaguePhotoRepository LeaguePhotoRepository
                 */
                $leaguePhotoRepository = app(LeaguePhotoRepository::class);
                $leaguePhoto = $leaguePhotoRepository->getByImageId($comment->commented_item_id);

                if ( ! $leaguePhoto) {
                    throw new LeaguePhotoNotFound;
                }

                if ($leaguePhoto->league->user->id === $user->id) {
                    $isOwner = true;
                }

                break;


            case Video::class:
                /**
                 * @var $videoRepository VideoRepository
                 */
                $videoRepository = app(VideoRepository::class);

                $video = $videoRepository->getById($comment->commented_item_id);

                if ( ! $video) {
                    throw new VideoNotFound;
                }

                /**
                 * @var $leagueVideoRepository LeagueVideoRepository
                 */
                $leagueVideoRepository = app(LeagueVideoRepository::class);
                $leagueVideo = $leagueVideoRepository->getByVideoId($comment->commented_item_id);

                if ( ! $leagueVideo) {
                    throw new LeaguePhotoNotFound;
                }

                if ($leagueVideo->league->user->id === $user->id) {
                    $isOwner = true;
                }

                break;

        }

        if ( ! $isOwner && $comment->user->id !== $user->id) {
            throw new NotPermissionException("You can not delete other people's comment");
        }

        $comment->delete();

        return true;
    }
}
