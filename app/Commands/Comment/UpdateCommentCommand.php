<?php

namespace Wooter\Commands\Comment;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\CountValidator\Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Image;
use Wooter\LeaguePermission;
use Wooter\Like;
use Wooter\Video;
use Wooter\Wooter\Exceptions\CommentNotFound;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
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

class UpdateCommentCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $comment;
    /**
     * @var
     */
    private $commentId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $comment_id
     * @param $comment
     */
    public function __construct($user_id, $comment_id, $comment)
    {
        $this->userId = $user_id;
        $this->comment = $comment;
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
     * @throws NotPermissionException
     * @throws UserNotFound
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

        if ($comment->user->id !== $user->id) {
            throw new NotPermissionException("You can not edit other people's comment");
        }

        $comment->comment = $this->comment;

        $commentRepository->update($comment);

        return $comment;
    }
}
