<?php

namespace Wooter\Http\Controllers\API\Team;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as RequestObject;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Team\CreateTeamPlayersCommand;
use Wooter\Commands\Team\ReadTeamPlayersCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Team\CreateTeamPlayersRequest;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Player\PlayerTransformer;

class TeamPlayersController extends ApiController
{
    private $playerTransformer;

    public function __construct(PlayerTransformer $playerTransformer)
    {
        $this->playerTransformer = $playerTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }


    /**
     * @api               {get} api/teams/:teamId/players Index
     *  @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          Team Players
     * @apiPermission     Requires JWT.
     * @apiDescription    Returns an array of all the players that are in a team filtered by parameters
     *
     * @apiParam {string} [order_by] Order by
     * @apiParam {integer} [order_direction] Direction of order
     * @apiParam {integer} [offset] Offset
     * @apiParam {integer} [limit] Limit
     * @apiParam {decimal} [competition_type] Type of the competition of the team
     * @apiParam {decimal} [competition_id] ID of the competition where the team plays
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => $player->id,
     *              'email' => $player->email,
     *              'first_name' => $player->first_name,
     *              'last_name' => $player->last_name,
     *              'phone' => $player->phone,
     *              'birthday' => $player->birthday,
     *              'gender' => $player->gender,
     *              'picture' => $player->picture,
     *              'school' => $player->school,
     *              'position' => $player->position,
     *              'city' => $player->city,
     *              'state' => $player->state,
     *              'name' => $player->first_name . ' ' . $player->last_name,
     *              'teams' => CollectionOfTeams
     *          ]
     *     }
     *
     * @apiUse            TeamNotFound
     *
     * @param $teamId
     *
     * @return JsonResponse
     */
    public function index($teamId)
    {
        try {
            $players = $this->dispatchFrom(ReadTeamPlayersCommand::class, new RequestObject(Request::all()), ['team_id' => $teamId]);

            $this->playerTransformer->teamId = $teamId;

            return $this->respond([
                'data' => $this->playerTransformer->transformCollection($players)
            ]);

        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/teams/:teamId/players Create
     *  @apiVersion        1.0.0
     * @apiName           Create a new player for a team
     * @apiGroup          Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Creates a new team
     *
     * @apiParam {array/Number} players Players to be added to the team
     * @apiParam {Number} competition_id ID of the competition of the team
     * @apiParam {String} competition_type Type of the competition of the team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'message' =>
     *          [
     *              'Success'
     *          ]
     *     }
     *
     * @param CreateTeamPlayersRequest $request
     * @param                          $teamId
     *
     * @apiUse            UserNotFound
     * @apiUse            TeamNotFound
     * @apiUse            PlayerNotFound
     * @apiUse            NotPermissionException
     *
     * @return JsonResponse
     */
    public function store(CreateTeamPlayersRequest $request, $teamId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFrom(CreateTeamPlayersCommand::class, $request, ['team_id' => $teamId, 'user_id' => $user->id]);

            return $this->respond([
                'message' => 'Success'
            ]);

        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (TeamNotFound $e) {
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
