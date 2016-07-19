<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\League\CreateLeaguePriceCommand;
use Wooter\Commands\Organization\League\DeleteLeaguePriceCommand;
use Wooter\Commands\Organization\League\ReadLeaguePriceCommand;
use Wooter\Commands\Organization\League\ReadLeaguePricesCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePriceCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeaguePriceRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeaguePriceRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePriceNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeaguePricesTransformer;

final class LeagueOrganizationPricesController extends ApiController
{
    /**
     * @var LeaguePricesTransformer
     */
    private $leaguePricesTransformer;

    /**
     * @param LeaguePricesTransformer $leaguePricesTransformer
     */
    public function __construct(LeaguePricesTransformer $leaguePricesTransformer) {

        $this->leaguePricesTransformer = $leaguePricesTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
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
            $leaguePrices = $this->dispatchFromArray(ReadLeaguePricesCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leaguePricesTransformer->transformCollection($leaguePrices)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeaguePriceRequest $request
     *
     * @param                          $leagueId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLeaguePriceRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueReview = $this->dispatchFrom(CreateLeaguePriceCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leaguePricesTransformer->transform($leagueReview)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $leagueId
     * @param $leaguePriceId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($leagueId, $leaguePriceId)
    {
        try
        {
            $team = $this->dispatchFromArray(ReadLeaguePriceCommand::class, ['league_id' => $leagueId, 'league_price_id' => $leaguePriceId]);

            return $this->respond([
                'data' => $this->leaguePricesTransformer->transform($team)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePriceNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|UpdateLeaguePriceRequest $request
     * @param                                  $leagueId
     * @param                                  $leaguePriceId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateLeaguePriceRequest $request, $leagueId, $leaguePriceId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $leaguePrice = $this->dispatchFrom(UpdateLeaguePriceCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId, 'league_price_id' => $leaguePriceId]);

            return $this->respond([
                'data' => $this->leaguePricesTransformer->transform($leaguePrice)
            ]);

        } catch (LeagueNotFound $e) {
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
     * Remove the specified resource from storage.
     *
     * @param $leagueId
     * @param $leaguePriceId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($leagueId, $leaguePriceId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeaguePriceCommand::class, ['league_id'=> $leagueId, 'league_price_id'=> $leaguePriceId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Successfully Deleted'
            ]);

        } catch (LeaguePriceNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(LeagueNotFound $e) {
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
