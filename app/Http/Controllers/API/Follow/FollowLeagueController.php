<?php

namespace Wooter\Http\Controllers\API\Follow;

use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Follow\ReadFollowLeagueCommand;
use Wooter\Commands\Follow\ReadFollowLeaguesCommand;
use Wooter\Commands\Follow\ToggleFollowLeagueCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Follow\ToggleFollowLeagueRequest;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Follow\FollowLeagueTransformer;

class FollowLeagueController extends ApiController
{

    /**
     * @var FollowLeagueTransformer
     */
    private $followLeagueTransformer;

    /**
     * @param FollowLeagueTransformer $followLeagueTransformer
     */
    public function __construct(FollowLeagueTransformer $followLeagueTransformer) {
        $this->followLeagueTransformer = $followLeagueTransformer;

        $this->middleware('jwt.auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $followLeagues = $this->dispatchFromArray(ReadFollowLeaguesCommand::class, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->followLeagueTransformer->transformCollection($followLeagues)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|ToggleFollowLeagueRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ToggleFollowLeagueRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $followLeague = $this->dispatchFrom(ToggleFollowLeagueCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->followLeagueTransformer->transform($followLeague),
                'message' => 'Success'
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
     * Display the specified resource.
     *
     * @param $leagueId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $followLeague = $this->dispatchFromArray(ReadFollowLeagueCommand::class, ['league_id' => $leagueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->followLeagueTransformer->transform($followLeague),
                'message' => 'Success'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
