<?php

namespace Wooter\Http\Controllers\API\Division;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Team\CreateDivisionCommand;
use Wooter\Commands\Team\DeleteDivisionCommand;
use Wooter\Commands\Team\ReadDivisionCommand;
use Wooter\Commands\Team\UpdateDivisionCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Team\CreateDivisionRequest;
use Wooter\Http\Requests\Team\UpdateDivisionRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\DivisionNotBelongToUser;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Exception;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Transformers\Team\DivisionTransformer;

final class DivisionsController extends ApiController
{
    /**
     * @var DivisionTransformer
     */
    private $divisionTransformer;

    /**
     * @param DivisionTransformer $divisionTransformer
     */
    public function __construct(DivisionTransformer $divisionTransformer) {
        $this->divisionTransformer = $divisionTransformer;
    }

    /**
     * @api               {post} api/division Create
     * @apiName           Create
     * @apiGroup          Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new Division for a league
     *
     * @apiParam {Number} league_id ID of the league to add the division to
     * @apiParam {String} name The name of the division
     *
     * @apiSuccess        Object Division
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'league_id' => '6',
     *              'name' => 'First Division',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateDivisionRequest $request
     *
     * @return array
     */
    public function store(CreateDivisionRequest $request)
    {
        try
        {
            $division = $this->dispatchFrom(CreateDivisionCommand::class, $request, ['user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($division)
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/division/:divisionId Read
     * @apiName           Read
     * @apiGroup          Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a league division
     *
     * @apiParam {Number} division_id Id of the Division
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'league_id' => '6',
     *              'name' => 'First Division',
     *          ]
     *     }
     *
     *
     * @apiUse            DivisionNotFound
     * @apiUse            NotPermissionException
     *
     * @param $divisionId
     *
     * @return array
     */
    public function show($divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $photo = $this->dispatchFromArray(ReadDivisionCommand::class, ['division_id' => $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($photo)
            ]);

        } catch (DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/division/:leagueId Update
     * @apiName           Update
     * @apiGroup          Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league division
     *
     * @apiParam {Number} division_id League id
     * @apiParam {String} name The new name for the division
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'league_id' => '6',
     *              'name' => 'First Division',
     *          ]
     *     }
     *
     * @apiUse            DivisionNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param UpdateDivisionRequest $request
     * @param                          $divisionId
     *
     * @return array
     */
    public function update(UpdateDivisionRequest $request, $divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $division = $this->dispatchFrom(UpdateDivisionCommand::class, $request, ['division_id' => $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->divisionTransformer->transform($division)
            ]);

        } catch (DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (DivisionNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/division/:divisionId Delete
     * @apiName           Delete
     * @apiGroup          Division
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league division
     *
     * @apiParam {Number} division_id of the league division to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            DivisionNotFound
     * @apiUse            DivisionNotBelongToUser
     * @apiUse            DatabaseException
     *
     *
     * @param $divisionId
     *
     * @return array
     */
    public function destroy($divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteDivisionCommand::class,['division_id' => $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (DivisionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (DivisionNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
