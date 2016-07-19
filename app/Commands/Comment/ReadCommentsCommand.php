<?php

namespace Wooter\Commands\Comment;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery\CountValidator\Exception;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Comment;
use Wooter\Http\Controllers\API\ApiController;
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

class ReadCommentsCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $commentedItemId;
    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $offset;
    /**
     * @var
     */
    private $limit;
    /**
     * @var bool
     */
    private $totalCount;

    /**
     * Create a new command instance.
     *
     * @param      $commented_item_id
     * @param      $type
     * @param bool $total_count
     * @param int  $offset
     * @param int  $limit
     */
    public function __construct($commented_item_id,
                                $type,
                                $total_count = false,
                                $offset = ApiController::DEFAULT_OFFSET,
                                $limit = ApiController::DEFAULT_LIMIT)
    {
        $this->commentedItemId = $commented_item_id;
        $this->type = $type;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->totalCount = $total_count;
    }

    /**
     * Execute the command.
     *
     * @param CommentRepository $commentRepository
     *
     * @return void|Like
     */
    public function handle(CommentRepository $commentRepository)
    {
        if ($this->totalCount) {
            return $commentRepository->getCountByItem($this->commentedItemId, $this->type);
        }

        return $commentRepository->getByItemWithOffsetAndLimit($this->commentedItemId, $this->type, $this->offset, $this->limit);

    }
}
