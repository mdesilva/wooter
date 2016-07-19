<?php

namespace Wooter\Http\Controllers\API\Division;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Team\CreateDivisionTeamsCommand;
use Wooter\Commands\Team\ReadDivisionTeamsCommand;
use Wooter\Commands\Team\UpdateDivisionTeamsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Team\CreateDivisionTeamsRequest;
use Wooter\Http\Requests\Team\UpdateDivisionTeamsRequest;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Team\DivisionNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Team\DivisionRepository;
use Wooter\Wooter\Transformers\Team\TeamTransformer;

class DivisionTeamsController extends ApiController
{
    /**
     * @var TeamTransformer
     */
    private $teamTransformer;
    /**
     * @var DivisionRepository
     */
    private $divisionRepository;

    /**
     * @param TeamTransformer    $teamTransformer
     * @param DivisionRepository $divisionRepository
     */
    public function __construct(TeamTransformer $teamTransformer, DivisionRepository $divisionRepository) {
        $this->teamTransformer = $teamTransformer;
        $this->divisionRepository = $divisionRepository;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $divisionId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $teams = $this->dispatchFromArray(ReadDivisionTeamsCommand::class, ['division_id' => $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->teamTransformer->transformCollection($teams)
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
     * Store a newly created resource in storage.
     *
     * @param Request|CreateDivisionTeamsRequest $request
     * @param                                    $divisionId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDivisionTeamsRequest $request, $divisionId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFrom(CreateDivisionTeamsCommand::class, $request, ['division_id' => $divisionId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (DivisionNotFound $e) {
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
