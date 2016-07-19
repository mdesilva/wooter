<?php

namespace Wooter\Commands\Likes;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\CountValidator\Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Image;
use Wooter\LeaguePermission;
use Wooter\Like;
use Wooter\Video;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\LikeRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePermissionRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\VideoRepository;

class ReadLikesCommand extends Command implements SelfHandling
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
    private $type;
    /**
     * @var bool
     */
    private $byMe;
    /**
     * @var bool
     */
    private $totalCount;
    /**
     * @var
     */
    private $limit;
    /**
     * @var
     */
    private $offset;

    /**
     * Create a new command instance.
     *
     * @param      $user_id
     * @param      $liked_item_id
     * @param      $type
     * @param bool $by_me
     * @param bool $total_count
     * @param      $limit
     * @param      $offset
     *
     * @internal param $like
     */
    public function __construct($user_id, $liked_item_id, $type,
                                $by_me = false,
                                $total_count = false,
                                $limit = ApiController::DEFAULT_LIMIT,
                                $offset = ApiController::DEFAULT_OFFSET)
    {
        $this->userId = $user_id;
        $this->likedItemId = $liked_item_id;
        $this->type = $type;
        $this->byMe = $by_me;
        $this->totalCount = $total_count;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @param LikeRepository $likeRepository
     *
     * @return void|Like
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, LikeRepository $likeRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ($this->byMe) {
            $like = $likeRepository->getByUserAndItem($this->userId, $this->likedItemId, $this->type);

            if ($like && $like->liked) {
                return true;
            }

            return false;
        }

        if ($this->totalCount) {
            return $likeRepository->getCountByItem($this->likedItemId, $this->type);
        }

        return $likeRepository->getByItemWithOffsetAndLimit($this->likedItemId, $this->type, $this->offset, $this->limit);

    }
}
