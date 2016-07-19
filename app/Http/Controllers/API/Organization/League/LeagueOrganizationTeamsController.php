<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as RequestObject;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Organization\League\CreateLeagueTeamCommand;
use Wooter\Commands\Organization\League\DeleteLeagueTeamCommand;
use Wooter\Commands\Organization\League\ReadLeagueTeamCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueTeamsCommand;
use Wooter\Http\Requests\Organization\League\CreateLeagueTeamRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Team\TeamTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class LeagueOrganizationTeamsController extends ApiController
{
    private $teamTransformer;
    
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
     * @api               {get} api/leagues/:leagueId/teams Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Team
     * @apiDescription    Returns an array of all the teams on the league that matches the filter parameters
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
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId)
    {
        try {
            $result = $this->dispatchFrom(ReadLeagueTeamsCommand::class, new RequestObject(Request::all()), ['league_id' => $leagueId]);

            $this->teamTransformer->leagueId = $leagueId;

            return $this->respond([
                'data' => ['teams' => $this->teamTransformer->transformCollection($result['teams']),
                    'pages' => $result['pages']
                ]
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/teams Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Adds a team to the league
     *
     * @apiParam {Number} league_id ID of the league
     * @apiParam {Number} team_id ID of the team
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
     * @apiUse            LeagueNotFound
     * @apiUse            TeamNotFound
     * @apiUse            UserNotFound
     * @apiUse            NotPermissionException
     *
     * @param CreateLeagueTeamRequest $request
     * @param                         $leagueId
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueTeamRequest $request, $leagueId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFrom(CreateLeagueTeamCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/:teamId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Team
     * @apiDescription    Gets a team that is part of the league
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Number} teamId Id of the Team
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
     * @param $leagueId
     * @param $teamId
     *
     * @return JsonResponse
     */
    public function show($leagueId, $teamId)
    {
        try
        {
            $team = $this->dispatchFromArray(ReadLeagueTeamCommand::class, ['league_id' => $leagueId, 'team_id' => $teamId]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($team)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/teams/:teamId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Deletes a team from a league.
     *
     * @apiParam {Number} leagueId ID of the league
     * @apiParam {Number} teamId ID of the team to be deleted
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            DatabaseException
     * @apiUse            UserHasNoOrganization
     * @apiUse            UserNotFound
     *
     * @param $leagueId
     * @param $teamId
     *
     * @return JsonResponse
     * @internal          param $playerId
     */
    public function destroy($leagueId, $teamId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueTeamCommand::class, ['league_id'=> $leagueId, 'team_id'=> $teamId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Successfully Deleted'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
