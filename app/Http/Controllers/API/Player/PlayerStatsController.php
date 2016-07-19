<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Mockery\Matcher\Not;
use Wooter\Commands\Player\UpdatePlayerStatCommand;
use Wooter\Commands\Player\CreatePlayerStatCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreatePlayerStatRequest;
use Wooter\Http\Requests\Player\UpdatePlayerStatRequest;
use Wooter\Wooter\Exceptions\Organization\League\DeleteException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerStatNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\StatNotFound;
use Wooter\Wooter\Repositories\Player\PlayerStatRepository;
use Illuminate\Support\Facades\Auth;

class PlayerStatsController extends ApiController
{
    /**
     * @var PlayerStatRepository
     */
    private $playerStatRepository;

    public function __construct(PlayerStatRepository $playerStatRepository) {

        $this->playerStatRepository = $playerStatRepository;
    }


    /**
     * @apiDefine PlayerNotFound
     * @apiError (Error 404) LeagueNotFound The <code>id</code> player (the user_id) was not found.
     *
     * @apiErrorExample {json} Error-PlayerNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "PlayerNotFound"
     *     }
     */

    /**
     * @apiDefine StatNotFound
     * @apiError (Error 404) StatNotFound The <code>id</code> of the Stat was not found
     *
     * @apiErrorExample {json} Error-StatNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "StatNotFound"
     *     }
     */

    /**
     * @apiDefine PlayerStatNotFound
     * @apiError (Error 404) PlayerStatNotFound The <code>id</code> of the relation between
     *            the player and the stat was not found
     *
     * @apiErrorExample {json} Error-PlayerStatNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "PlayerStatNotFound"
     *     }
     */

    /**
     * @api               {post} api/player-stat Create
     * @apiName           Create
     * @apiGroup          Player Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Express a stat for a user
     *
     * @apiParam {Number} player_id ID of the player.
     * @apiParam {Number} stat_id ID of the sport.
     *
     * @apiSuccess        Object PlayerStat
     *
     * @apiSuccess        player_id The id of the player
     * @apiSuccess        stat_id The id of the stat of the user
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'player_id' => '1',
     *              'stat_id' => '2',
     *          ]
     *     }
     *
     * @apiUse            PlayerNotFound
     * @apiUse            StatNotFound
     *
     * @param CreatePlayerStatRequest $request
     *
     * @return array
     */
    public function store(CreatePlayerStatRequest $request)
    {
        try
        {
            $this->content = $this->dispatchFrom(CreatePlayerStatCommand::class, $request);
        } catch (PlayerNotFound $e) {
            $this->error = $e->getMessage();
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
     * @api               {get} api/player-stat/:playerStatId Read
     * @apiName           Read
     * @apiGroup          Player Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a player stat relation
     *
     * @apiParam {Number} player_stat_id Id of the Player Stat relation
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'id' => '2',
     *              'player_id' => '1',
     *              'stat_id' => '2',
     *          ]
     *     }
     *
     * @apiUse            PlayerStatNotFound
     * @apiUse            NotPermissionException
     *
     * @param $playerStatId
     *
     * @return array
     */
    public function show($playerStatId)
    {
        $playerStat = $this->playerStatRepository->getById($playerStatId);

        if ($playerStat)
        {
            if ($playerStat->player->id === Auth::user()->id)
            {
                $this->content = $playerStat;
            } else {
                $this->error = new Not('The user has no access to this stat');
            }
        } else {
            $this->error = new PlayerStatNotFound;
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }

    /**
     * @api               {put} api/player-stat/:playerStatId Update
     * @apiName           Update
     * @apiGroup          Player Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the player stat relation
     *
     * @apiParam {Number} player_stat_id Id of the player league relation
     * @apiParam {Number} player_id ID of the player.
     * @apiParam {Number} stat_id ID of the stat.
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'id' => '6',
     *              'player_id' => '1',
     *              'stat_id' => '2',
     *          ]
     *     }
     *
     * @apiUse            StatNotFound
     * @apiUse            PlayerNotFound
     * @apiUse            PlayerStatNotFound
     *
     * @param UpdatePlayerStatRequest $request
     * @param                         $playerStatId
     *
     * @return array
     */
    public function update(UpdatePlayerStatRequest $request, $playerStatId)
    {
        try
        {
            $this->content = $this->dispatchFrom(UpdatePlayerStatCommand::class, $request, ['player_stat_id' => $playerStatId]);
        } catch (StatNotFound $e) {
            $this->error = $e->getMessage();
        } catch (PlayerNotFound $e) {
            $this->error = $e->getMessage();
        } catch (PlayerStatNotFound $e) {
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
     * @api               {delete} api/player-stat/:playerStatId Delete
     * @apiName           Delete
     * @apiGroup          Player Stat
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the player stat relation
     *
     * @apiParam {Number} player_stat_id Id of the player stat to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' => 'Deleted'
     *     }
     *
     * @apiUse            DeleteException
     * @apiUse            NotPermissionException
     * @apiUse            PlayerStatNotFound
     *
     *
     * @param $playerStatId
     *
     * @return array
     */
    public function destroy($playerStatId)
    {
        $playerStat = $this->playerStatRepository->getById($playerStatId);

        if ($playerStat)
        {
            if ($playerStat->player->id === Auth::User()->id)
            {
                if (!$playerStat->delete())
                {
                    $this->error = new DeleteException;
                }
            } else {
                $this->error = new NotPermissionException('This player has not access to this stat');
            }
        } else {
            $this->error = new PlayerStatNotFound;
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }
}
