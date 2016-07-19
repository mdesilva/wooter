<?php

namespace Wooter\Commands\User;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Http\Controllers\API\ApiController;


class ReadUsersCommand extends Command implements SelfHandling
{
    /**
     * @var int
     */
    private $offset;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $orderDirection;

    /**
     * @param int    $offset
     * @param int    $limit
     * @param string $order_by
     * @param string $order_direction
     */
    public function __construct($offset = ApiController::DEFAULT_OFFSET, $limit = ApiController::DEFAULT_LIMIT, $order_by = ApiController::DEFAULT_ORDER_BY, $order_direction = ApiController::DEFAULT_ORDER_DIRECTION)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $order_by;
        $this->orderDirection = $order_direction;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @return string
     */
    public function handle(UserRepository $userRepository)
    {
        return $userRepository->getByFilters($this->offset, $this->limit, $this->orderBy, $this->orderDirection);
    }
}



