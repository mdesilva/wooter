<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Wooter\Commands\Player\CreatePlayerAwardCommand;
use Wooter\Commands\Player\UpdatePlayerAwardCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreatePlayerAwardRequest;
use Wooter\Http\Requests\Player\UpdatePlayerAwardRequest;
use Wooter\Wooter\Exceptions\Player\AwardNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerAwardNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\Player\PlayerAwardRepository;
use Illuminate\Support\Facades\Auth;

class PlayerAwardsController extends ApiController
{
    /**
     * @var PlayerAwardRepository
     */
    private $playerAwardRepository;

    public function __construct(PlayerAwardRepository $playerAwardRepository) {

        $this->playerAwardRepository = $playerAwardRepository;
    }

    /**
     * @api               {post} api/player-award Create
     * @apiName           Create
     * @apiGroup          Player Award
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new relation between a player and an award
     *
     * @apiParam {Number} player_id ID of the player.
     * @apiParam {Number} award_id ID of the award.
     *
     * @apiSuccess        Object PlayerAward
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' =>
     *          [
     *              'player_id' => '1',
     *              'award_id' => '2',
     *          ]
     *     }
     *
     *@apiUse            PlayerNotFound
     *@apiUse            AwardNotFound
     *
     * @param CreatePlayerAwardRequest $request
     *
     * @return array
     */
    public function store(CreatePlayerAwardRequest $request)
    {
        try
        {
            $this->content = $this->dispatchFrom(CreatePlayerAwardCommand::class, $request);
        } catch (PlayerNotFound $e) {
            $this->error = $e->getMessage();
        } catch (AwardNotFound $e) {
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
     * @api               {get} api/player-award/:playerAwardId Read
     * @apiName           Read
     * @apiGroup          Player Award
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a relation between a player and an award
     *
     * @apiParam {Number} award_id Id of the award
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
     *              'award_id' => '2',
     *          ]
     *     }
     *
     * @apiUse            PlayerAwardNotFound
     *
     * @param $playerAwardId
     *
     * @return array
     *
     */
    public function show($playerAwardId)
    {
        $playerAward = $this->playerAwardRepository->getById($playerAwardId);

        if ($playerAward)
        {
            if ($playerAward->player->id === Auth::user()->id)
            {
                $this->content = $playerAward;
            } else {
                $this->error = 'The user has no access to this award';
            }
        } else {
            $this->error = 'Player award was not found';
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }

    /**
     * @api               {put} api/player-award/:playerAwardId Update
     * @apiName           Update
     * @apiGroup          Player Award
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the player award relation
     *
     * @apiParam {Number} player_award_id Id of the award
     * @apiParam {Number} player_id ID of the player.
     * @apiParam {Number} award_id ID of the award.
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
     *              'award_id' => '2',
     *          ]
     *     }
     *
     * @apiUse            PlayerAwardNotFound
     * @apiUse            AwardNotFound
     * @apiUse            PlayerNotFound
     *
     * @param UpdatePlayerAwardRequest $request
     * @param Number                   $playerAwardId
     *
     * @return array
     *
     */
    public function update(UpdatePlayerAwardRequest $request, $playerAwardId)
    {
        try
        {
            $this->content = $this->dispatchFrom(UpdatePlayerAwardCommand::class, $request, ['player_award_id' => $playerAwardId, 'user_id' => Auth::User()->id]);
        } catch (AwardNotFound $e) {
            $this->error = $e->getMessage();
        } catch (PlayerNotFound $e) {
            $this->error = $e->getMessage();
        } catch (PlayerAwardNotFound $e) {
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
     * @api               {delete} api/player-award/:playerAwardId Delete
     * @apiName           Delete
     * @apiGroup          Player Award
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the player award relation
     *
     * @apiParam {Number} Id of the league video to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => true,
     *          'error' => false,
     *          'content' => 'Deleted'
     *     }
     *
     * @apiUse            PlayerAwardNotFound
     *
     * @param $playerAwardId
     *
     * @return array
     */
    public function destroy($playerAwardId)
    {
        $playerAward = $this->playerAwardRepository->getById($playerAwardId);

        if ($playerAward)
        {
            if ($playerAward->player->id === Auth::User()->id)
            {
                if (!$playerAward->delete())
                {
                    $this->error = 'There was an error when deleting the player award';
                }
            } else {
                $this->error = 'This player has not access to this award';
            }
        } else {
            $this->error = new PlayerAwardNotFound;
        }

        return [
            'success' => ! $this->error,
            'error' => $this->error,
            'content' => $this->content
        ];
    }
}
