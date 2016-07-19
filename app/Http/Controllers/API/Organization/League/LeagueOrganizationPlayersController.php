<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as RequestObject;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Organization\League\DeleteLeaguePlayerCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePlayerCommand;
use Wooter\Commands\Player\CreatePlayerLeagueJoinByInviteCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Organization\League\CreatePlayerInviteToLeagueRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeaguePlayerRequest;
use Wooter\RegularStage;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedTeamAsLeague;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Commands\Organization\League\ReadLeaguePlayersCommand;
use Wooter\Commands\Organization\League\CreateLeaguePlayerCommand;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Transformers\Player\PlayerTransformer;


final class LeagueOrganizationPlayersController extends ApiController
{
    /**
     * @var PlayerTransformer
     */
    private $playerTransformer;
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * @param PlayerTransformer $playerTransformer
     * @param LeagueRepository  $leagueRepository
     */
    public function __construct(PlayerTransformer $playerTransformer, LeagueRepository $leagueRepository)
    {
        $this->playerTransformer = $playerTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @api               {get} api/leagues/:leagueId/players Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Player
     * @apiDescription    Returns an array of all the player on the league that matches the filter parameters
     *
     * @apiParam {Number} leagueId Id of the league
     * @apiParam {string} [order_by] Order by
     * @apiParam {integer} [order_direction] Direction of order
     * @apiParam {integer} [offset] Offset
     * @apiParam {integer} [limit] Limit
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
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId)
    {
        try {
            $result = $this->dispatchFrom(ReadLeaguePlayersCommand::class, new RequestObject(Request::all()), ['league_id' => $leagueId]);

            $this->playerTransformer->stageId = $this->leagueRepository->getFirstStageByLeagueId($leagueId)->id;
            $this->playerTransformer->stageType = RegularStage::class;

            return $this->respond([
                'data' => ['players' => $this->playerTransformer->transformCollection($result['users']), 'pages' => $result['pages']]
            ]);
            
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/players Create
     * @apiVersion        1.0.0
     * @apiName           Invite player
     * @apiGroup          League Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Invites and creates (if not exists) a player to join the league
     *
     * @apiParam {Number} leagueId Id of the league
     * @apiParam {String} email Email, must be unique
     * @apiParam {String} first_name First name
     * @apiParam {String} last_name Last name of the player
     * @apiParam {String} phone Phone of the player
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
     * @param CreatePlayerInviteToLeagueRequest $request
     *
     * @param                                   $leagueId
     *
     * @return JsonResponse
     * @apiUse            UserNotFound
     * @apiUse            NotPermissionException
     * @apiUse            LeagueNotFound
     *
     */
    public function store(CreatePlayerInviteToLeagueRequest $request, $leagueId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $player = $this->dispatchFrom(CreateLeaguePlayerCommand::class, $request, ['league_id' => $leagueId, 'user_id' => $user->id]);
       
            return $this->respond([
                'message' => 'Invitation Successfully Sent',
                'data' => $this->playerTransformer->transform($player)
            ]);

        } catch (UserNotFound $e) {
            return  $this->respondNotFound($e->getMessage());

        } catch (LeagueNotFound $e) {
            return  $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return  $this->respondNotAuthorized($e->getMessage());

        } catch (Exception $e) {
            return  $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/players/:playerId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Deletes a player from a league. It will also delete the player from the teams where he was playing on that league.
     *
     * @apiParam {Number} leagueId ID of the league
     * @apiParam {Number} playerId ID of the player to be deleted
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Successfully Deleted'
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            PlayerNotFound
     * @apiUse            UserNotFound
     * @apiUse            NotPermissionException
     * @apiUse            DatabaseException
     *
     * @param $leagueId
     * @param $playerId
     *
     * @return JsonResponse
     * @internal          param $teamId
     *
     */
    public function destroy($leagueId, $playerId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeaguePlayerCommand::class, ['league_id'=> $leagueId, 'player_id'=> $playerId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Successfully Deleted'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/:token/:email/join-by-invitation joinByInvitation
     * @apiVersion        1.0.0
     * @apiName           joinByInvitation
     * @apiGroup          League Player
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Invites a player from a league.
     *
     * @apiParam {Number} leagueId ID of the league
     * @apiParam {String} email Email of the player to be invited
     * @apiParam {String} token token
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'createLeagueSuccess' => 'You have been successfully added to the league'
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            PlayerNotFound
     * @apiUse            PlayerAlreadyJoinedLeague
     * @apiUse            PlayerAlreadyJoinedTeamAsLeague
     *
     * @param $leagueId , $token, $email
     *
     * @return JsonResponse
     *
     */
    
    public function joinByInvitation($leagueId, $token, $email)
    {
        try
        {
            $playerExists = $this->dispatchFromArray(CreatePlayerLeagueJoinByInviteCommand::class, ['league_id' => $leagueId, 'email' => $email, 'token' => $token]);

            if ($playerExists) {
                $this->respondWithAlert('createLeagueSuccess', 'You have been successfully added to the league');
                return redirect('/');
            } else {
                return redirect('registration');
            }
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        }  catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (PlayerAlreadyJoinedLeague $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (PlayerAlreadyJoinedTeamAsLeague $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
