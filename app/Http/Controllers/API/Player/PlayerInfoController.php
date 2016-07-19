<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Player\ChangeUserPasswordCommand;
use Wooter\Commands\Player\UpdatePlayerInfoCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\ChangeUserPasswordRequest;
use Wooter\Http\Requests\Player\UpdatePlayerInfoRequest;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Player\PlayerTransformer;

final class PlayerInfoController extends ApiController
{
    /**
     * @var PlayerTransformer
     */
    private $playerTransformer;

    /**
     * @param PlayerTransformer $playerTransformer
     */
    public function __construct(PlayerTransformer $playerTransformer)
    {
        $this->middleware('jwt.auth');

        $this->playerTransformer = $playerTransformer;
    }

    /**
     * @api               {put} api/player/info updateInfo
     * @apiVersion        1.0.0
     * @apiName           updateInfo
     * @apiGroup          PlayerInfo
     * @apiPermission     Requires JWT
     * @apiDescription    Updates player information
     *
     * @apiParam {Number} player_id ID of the player to update
     * @apiParam {String} email Email of the player
     * @apiParam {String} firstName First name of the player
     * @apiParam {String} lastName Last name of the player
     * @apiParam {String} phone Phone of the player
     * @apiParam {String} birthday Birthday of the player
     * @apiParam {String} city City of the player
     * @apiParam {String} state State of the player
     * @apiParam {String} position Position of the player
     * @apiParam {String} school School of the player
     * @apiParam {Enum}   gender Gender of the player
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => $player->id,
     *                  'email' => $player->email,
     *                  'first_name' => 'John',
     *                  'last_name' => 'Doe',
     *                  'phone' => $player->phone,
     *                  'gender' => $player->gender,
     *                  'picture' => $player->picture,
     *                  'school' => $player->school,
     *                  'position' => $player->position,
     *                  'city' => $player->city,
     *                  'state' => $player->state,
     *                  'name' => 'John Doe',
     *                  'current_team' => $current_team
     *              ]
     *          ]
     *     }
     *
     * @apiError            PlayerNotFound
     * @apiError            UserNotFound
     * @apiError            NotPermissionException
     *
     * @param UpdatePlayerInfoRequest $request
     *
     * @return JsonResponse
     */
    public function updateInfo(UpdatePlayerInfoRequest $request)
    {
        try
        {
            $player = JWTAuth::parseToken()->authenticate();

            $player = $this->dispatchFrom(UpdatePlayerInfoCommand::class, $request, ['player_id' => $player->id]);

            return $this->respond([
                'data' => $this->playerTransformer->transform($player)
            ]);
        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/player/change-password changePassword
     * @apiVersion        1.0.0
     * @apiName           changePassword
     * @apiGroup          PlayerInfo
     * @apiPermission     Requires JWT
     * @apiDescription    Updates a player password
     *
     * @apiParam {Number} player_id ID of the player to update
     * @apiParam {String} old_password Old password of the player
     * @apiParam {String} new_password New password of the player
     * @apiParam {String} confirm_password Confirm password of the player
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'data' => 'Password changed successfully',
     *              'message' => 'Password changed successfully',
     *          ]
     *     }
     *
     * @apiError            PlayerNotFound
     * @apiError            UserNotFound
     * @apiError            NotPermissionException
     *
     * @param ChangeUserPasswordRequest $request
     *
     * @return JsonResponse
     */

    public function changePassword(ChangeUserPasswordRequest $request)
    {
        try
        {
            $player = JWTAuth::parseToken()->authenticate();

            $this->dispatchFrom(ChangeUserPasswordCommand::class, $request, ['player_id' => $player->id]);

            return $this->respond([
                'data' => 'Password changed successfully',
                'message' => 'Password changed successfully',
            ]);
        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
