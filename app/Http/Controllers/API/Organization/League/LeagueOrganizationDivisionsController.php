<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Commands\Organization\League\CreateLeagueDivisionCommand;
use Wooter\Commands\Organization\League\DeleteLeagueDivisionCommand;
use Wooter\Commands\Organization\League\ReadLeagueDivisionCommand;
use Wooter\Commands\Organization\League\UpdateLeagueDivisionCommand;
use Wooter\Http\Requests\Organization\League\CreateLeagueDivisionRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueDivisionRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueDivisionsCommand;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Wooter\Transformers\Team\DivisionTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;

final class LeagueOrganizationDivisionsController extends ApiController
{
    /**
     * @var DivisionTransformer
     */
    private $divisionTransformer;

    /**
     * @param DivisionTransformer $divisionTransformer
     */
    public function __construct(DivisionTransformer $divisionTransformer)
    {
        $this->divisionTransformer = $divisionTransformer;

        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/divisions Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, admin
     * @apiGroup          League Division
     * @apiDescription    Returns the League Divisions for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     *
     * @apiSuccess Object LeagueDivision
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'name' => 'First Division',
     *                  'league_id' => 1,
     *              },
     *              {
     *                  'id' => 2,
     *                  'name' => 'Second Division',
     *                  'league_id' => 1,
     *              }
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            DivisionNotFound
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId)
    {
        try {
            $request = Request::all();
            $divisions = $this->dispatchFrom(ReadLeagueDivisionsCommand::class, new RequestObject($request), ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->divisionTransformer->transformCollection($divisions)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/divisions Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new League Division for the League
     *
     * @apiParam {Number} leagueId League id of the league to save the division
     * @apiParam {String} name Name of the division
     *
     * @apiSuccess        Object LeagueDivision
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'name' => 'First Division',
     *              'league_id' => 1,
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            UserNotFound
     * @apiUse            DivisionNotFound
     * @apiUse            NotPermissionException
     *
     *
     * @param CreateLeagueDivisionRequest $request , $leagueId
     *
     * @param                             $leagueId
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueDivisionRequest $request, $leagueId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $division = $this->dispatchFrom(CreateLeagueDivisionCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($division)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            dd($e->getFile(), $e->getLine());
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/divisions/:divisionId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a the league division
     * @apiParam {Number} LeagueId Id of the League
     * @apiParam {Number} divisionId Division Id of the division
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'name' => 'First Division',
     *              'league_id' => 1,
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            DivisionNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leagueId
     * @param $divisionId
     *
     * @return JsonResponse
     * @internal          param $leagueLocationId
     *
     */
    public function show($leagueId, $divisionId)
    {
        try
        {
            $division = $this->dispatchFromArray(ReadLeagueDivisionCommand::class, ['league_id' => $leagueId, 'division_id' => $divisionId]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($division)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());


        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @param UpdateLeagueDivisionRequest $request
     * @param                             $leagueId
     * @param                             $divisionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLeagueDivisionRequest $request, $leagueId, $divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $division = $this->dispatchFrom(UpdateLeagueDivisionCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId, 'division_id' => $divisionId]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($division)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());


        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * @api               {delete} api/leagues/:leagueId/divisions/:divisionId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league division
     *
     * @apiParam {Number} leagueId league id of the league
     * @apiParam {Number} divisionId league division id to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Successfully Deleted'
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            UserNotFound
     * @apiUse            DivisionNotFound
     * @apiUse            NotPermissionException
     * @apiUse            DatabaseException
     *
     * @param $leagueId
     * @param $divisionId
     *
     * @return JsonResponse
     * @internal          param $leagueLocationId
     *
     */
    public function destroy($leagueId, $divisionId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueDivisionCommand::class, ['league_id'=> $leagueId, 'division_id'=> $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Successfully Deleted'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
