<?php

namespace Wooter\Http\Controllers\API\Stat;

use Exception;
use Wooter\Commands\Player\CreateStatCommand;
use Wooter\Commands\Player\UpdateStatCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreateStatRequest;
use Wooter\Http\Requests\Player\UpdateStatRequest;
use Wooter\Wooter\Exceptions\Player\StatNotFound;
use Wooter\Wooter\Repositories\Player\StatRepository;

class StatsController extends ApiController
{
    /**
     * @var StatRepository
     */
    private $statRepository;

    public function __construct(StatRepository $statRepository) {

        $this->statRepository = $statRepository;
    }

    /**
     * @api               {post} api/stat Create
     * @apiName           Create
     * @apiGroup          Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new Stat
     *
     * @apiParam {String} metric Metric of the stat
     * @apiParam {Number} points_scored Points obtained in the stat
     *
     * @apiSuccess        Object Stat
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'metric' => 'Goal',
     *              'points_scored' => '1',
     *          ]
     *     }
     *
     *
     * @param CreateStatRequest $request
     *
     * @return array
     */
    public function store(CreateStatRequest $request)
    {
        try
        {
            $this->content = $this->dispatchFrom(CreateStatCommand::class, $request);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }

    /**
     * @api               {get} api/stat/:statId Read
     * @apiName           Read
     * @apiGroup          Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets an stat
     *
     * @apiParam {Number} stat_id Id of the stat
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'id' => '6',
     *              'metric' => 'Goal',
     *              'points_scored' => '1',
     *          ]
     *     }
     *
     * @param $statId
     *
     * @return array
     */
    public function show($statId)
    {
        $stat = $this->statRepository->getById($statId);

        if ($stat)
        {
            $this->content = $stat;
        } else {
            $this->error = 'Stat was not found';
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }

    /**
     * @api               {put} api/stat/:statId Update
     * @apiName           Update
     * @apiGroup          Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the stat
     *
     * @apiParam {Number} stat_id Id of the stat
     * @apiParam {Number} award_id Id of the stat
     * @apiParam {String} name Name of the stat.
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'id' => '6',
     *              'metric' => 'Goal',
     *              'points_scored' => '1',
     *          ]
     *     }
     *
     * @param UpdateStatRequest $request
     * @param                   $statId
     *
     * @return array
     */
    public function update(UpdateStatRequest $request, $statId)
    {
        try
        {
            $this->content = $this->dispatchFrom(UpdateStatCommand::class, $request, ['stat_id' => $statId]);
        } catch (StatNotFound $e) {
            $this->error = $e->getMessage();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }

    /**
     * @api               {delete} api/stat/:statId Delete
     * @apiName           Delete
     * @apiGroup          Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the stat
     *
     * @apiParam {Number} stat_id Id of the stat
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' => 'Deleted'
     *     }
     *
     * @param $statId
     *
     * @return array
     */
    public function destroy($statId)
    {
        $stat = $this->statRepository->getById($statId);

        if ($stat)
        {
            if (!$stat->delete())
            {
                $this->error = 'There was an error when deleting the stat';
            }
        } else {
            $this->error = 'This stat does not exist';
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }
}
