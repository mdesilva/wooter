<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Player\CreatePlayerCommand;
use Wooter\Commands\Player\DeletePlayerCommand;
use Wooter\Commands\Player\ReadPlayerCommand;
use Wooter\Commands\Player\UpdatePlayerCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreatePlayerRequest;
use Wooter\Http\Requests\Player\UpdatePlayerRequest;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Transformers\Player\PlayerTransformer;

class PlayersController extends ApiController
{
    /**
     * @var PlayerTransformer
     */
    private $playerTransformer;

    /**
     * @param PlayerTransformer $playerTransformer
     *
     * @internal param PlayerTransformer $teamTransformer
     */
    public function __construct(PlayerTransformer $playerTransformer)
    {
        $this->playerTransformer = $playerTransformer;
        $this->middleware('jwt.auth');
        $this->middleware('user.is_organization');
    }

    /**
     * @api               {post} api/players Create
     * @apiName           Create
     * @apiGroup          Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Creates a new Player
     *
     * @apiParam {String} email Email, must be unique
     * @apiParam {String} first_name First name
     * @apiParam {String} last_name Last name of the player
     * @apiParam {Number} phone Phone number
     * @apiParam {Number} birthday Birthday
     * @apiParam {String} [gender] Gender 'in:male,female,other'
     * @apiParam {File} [picture] Picture of the player
     * @apiParam {Number} [league_id] ID of the League that the player is being added to
     * @apiParam {Number} [team_id] ID of the Team that the player is being added to
     *
     * @apiSuccess        Object User
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          {
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
     * @param CreatePlayerRequest $request
     *
     * @return array
     */
    public function store(CreatePlayerRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $player = $this->dispatchFrom(CreatePlayerCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->playerTransformer->transform($player)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/players/:playerId Read
     * @apiName           Read
     * @apiGroup          Player
     * @apiDescription    Gets a player
     *
     * @apiParam {Number} player_id Id of the Player
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
     * @apiUse            PlayerNotFound
     *
     * @param $playerId
     *
     * @return array
     */
    public function show($playerId)
    {
        try
        {
            $player = $this->dispatchFromArray(ReadPlayerCommand::class, ['player_id' => $playerId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => $this->playerTransformer->transform($player)
            ]);

        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/players/:playerId Update
     * @apiName           Update
     * @apiGroup          Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Updates the player
     *
     * @apiParam {String} email Email, must be unique
     * @apiParam {String} first_name First name
     * @apiParam {String} last_name Last name of the player
     * @apiParam {Number} phone Phone number
     * @apiParam {Number} birthday Birthday
     * @apiParam {String} [gender] Gender 'in:male,female,other'
     * @apiParam {File} [picture] Picture of the player
     * @apiParam {Number} [league_id] ID of the League that the player is being added to
     * @apiParam {Number} [team_id] ID of the Team that the player is being added to
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
     * @apiUse            DivisionNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param UpdatePlayerRequest $request
     * @param                     $playerId
     *
     * @return JsonResponse
     */
    public function update(UpdatePlayerRequest $request, $playerId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $player = $this->dispatchFrom(UpdatePlayerCommand::class, $request, ['player_id' => $playerId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->playerTransformer->transform($player)
            ]);

        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/players/:playerId Delete
     * @apiName           Delete
     * @apiGroup          Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Deletes the player
     *
     * @apiParam {Number} player_id ID of the Player to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            PlayerNotFound
     * @apiUse            DatabaseException
     *
     *
     * @param $playerId
     *
     * @return JsonResponse
     */
    public function destroy($playerId)
    {
        try
        {
            $this->dispatchFromArray(DeletePlayerCommand::class,['player_id' => $playerId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
