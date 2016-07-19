<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\League\CreateLeaguePermissionCommand;
use Wooter\Commands\Organization\League\ReadLeaguePermissionsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Organization\League\CreateLeaguePermissionRequest;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePermissionPermissionLevelFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePermissionTypeNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeaguePermissionsTransformer;

final class LeagueOrganizationPermissionsController extends ApiController
{
    /**
     * @var LeaguePermissionsTransformer
     */
    private $leaguePermissionsTransformer;

    /**
     * @param LeaguePermissionsTransformer $leaguePermissionsTransformer
     */
    public function __construct(LeaguePermissionsTransformer $leaguePermissionsTransformer) {

        $this->leaguePermissionsTransformer = $leaguePermissionsTransformer;

        $this->middleware('jwt.auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @param $leagueId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($leagueId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $permissions = $this->dispatchFromArray(ReadLeaguePermissionsCommand::class, ['league_id' => $leagueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leaguePermissionsTransformer->transformCollection($permissions)
            ]);

        } catch (LeagueNotFound $e) {
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
     * Store a newly created resource in storage.
     *
     * @param CreateLeaguePermissionRequest $request
     *
     * @param                          $leagueId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLeaguePermissionRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leaguePermission = $this->dispatchFrom(CreateLeaguePermissionCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leaguePermissionsTransformer->transform($leaguePermission)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePermissionTypeNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePermissionPermissionLevelFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
