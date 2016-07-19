<?php

namespace Wooter\Http\Controllers\API\Team;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Wooter\Http\Controllers\API\ApiController;
use Exception;
use Wooter\Commands\Team\CreateTeamCommand;
use Wooter\Commands\Team\DeleteTeamCommand;
use Wooter\Commands\Team\UpdateTeamCommand;
use Wooter\Commands\Team\ReadTeamsCommand;
use Wooter\Commands\Team\ReadTeamCommand;
use Wooter\Http\Requests\Team\CreateTeamRequest;
use Wooter\Http\Requests\Team\UpdateTeamRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Team\TeamTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class TeamsController extends ApiController
{
    /**
     * @var TeamTransformer
     */
    private $teamTransformer;

    /**
     * @param TeamTransformer  $teamTransformer
     */
    public function __construct(TeamTransformer $teamTransformer)
    {
        $this->teamTransformer = $teamTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/teams Index
     *  @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          Team
     * @apiDescription    Returns an array of all the teams that matches the filter parameters
     *
     * @apiSuccess {Array} data Array with all the teams.
     *
     * @apiParam {integer} [player_id] ID of the player to get the teams
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     * @apiUse            UserNotFound
     *
     * @return JsonResponse
     */
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();

        $playerId = Request::get('player_id');
        
        try {
            $teams = $this->dispatchFromArray(ReadTeamsCommand::class, ['user_id' => $user->id, 'player_id' => $playerId]);

            return $this->respond([
                'data' => $this->teamTransformer->transformCollection($teams)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/teams Create
     * @apiVersion        1.0.0
     * @apiName           Create a new team
     * @apiGroup          Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Creates a new team
     *
     * @apiParam {String} name The name of the team
     * @apiParam {Number} sport_id ID of the sport that the team plays
     * @apiParam {File} [cover_photo] File of the cover photo
     * @apiParam {File} [logo] File of the logo
     * @apiParam {String} [description] Description of the team
     * @apiParam {Number} [captain_id] ID of the user that will be the captain of the team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     * @param CreateTeamRequest $request
     *
     * @apiUse            UserNotFound
     *
     * @return JsonResponse
     */
    public function store(CreateTeamRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $team = $this->dispatchFrom(CreateTeamCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($team)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/teams/:teamId Read
     *  @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          Team
     * @apiDescription    Gets a team
     *
     * @apiParam {Number} team_id Id of the Team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     *
     * @apiUse            TeamNotFound
     * @apiUse            UserNotFound
     *
     * @param $teamId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($teamId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try
        {
            $team = $this->dispatchFromArray(ReadTeamCommand::class, ['user_id' => $user->id, 'team_id' => $teamId]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($team)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (TeamNotFound $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/teams/:teamId Update
     *  @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Updates a team
     *
     * @apiParam {String} name The name of the team
     * @apiParam {File} [cover_photo] File of the cover photo
     * @apiParam {File} [logo] File of the logo
     * @apiParam {String} [description] Description of the team
     * @apiParam {Number} [captain_id] ID of the user that will be the captain of the team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     * @apiUse            TeamNotFound
     * @apiUse            UserNotFound
     * @apiUse            UserHasNoOrganization
     *
     * @param UpdateTeamRequest $request
     * @param                   $teamId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTeamRequest $request, $teamId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $team = $this->dispatchFrom(UpdateTeamCommand::class, $request, ['team_id' => $teamId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($team)
            ]);

        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/teams/:teamId Delete
     *  @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Deletes a team
     *
     * @apiParam {Number} team_id ID of the team to be deleted
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            TeamNotFound
     * @apiUse            DatabaseException
     * @apiUse            UserHasNoOrganization
     * @apiUse            UserNotFound
     *
     * @param $teamId
     *
     * @return JsonResponse
     */
    public function destroy($teamId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteTeamCommand::class,['team_id' => $teamId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}

