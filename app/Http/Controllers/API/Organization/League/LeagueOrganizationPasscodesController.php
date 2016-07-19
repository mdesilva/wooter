<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\CreateLeaguePasscodeCommand;
use Wooter\Http\Requests\Organization\League\CreateLeaguePasscodeRequest;
use Wooter\Wooter\Transformers\Organization\League\LeaguePasscodeTransformer;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePasscodeLength;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePasscodeAlreadyCreated;
use Tymon\JWTAuth\Facades\JWTAuth;

final class LeagueOrganizationPasscodesController extends ApiController
{
    /**
     * @var LeaguePasscodeTransformer
     */
    private $leaguePasscodeTransformer;


    /**
     * @param LeaguePasscodeTransformer $leaguePasscodeTransformer
     */
    public function __construct(LeaguePasscodeTransformer $leaguePasscodeTransformer) {

       $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
        $this->leaguePasscodeTransformer = $leaguePasscodeTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function create(Request $request)
    {



    }

    /**
     * @api               {post} api/league/:leagueId/create-passcode Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Passcodes
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Creates a new Passcode for the League
     *
     * @apiParam {Number} league_id League id of the league to create the passcode to
     * @apiParam {String} passcode Passcode for the league.
     *
     * @apiSuccess        Object LeagueOrganizationBasics
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'league_id' => '6',
     *              'sport_id' => '4',
     *              'min_age' => '14',
     *              'max_age' => '18',
     *              'gender' => 'female',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeaguePasscodeLength
     * @apiUse            LeaguePasscodeAlreadyCreated
     *
     * @param CreateLeaguePasscodeRequest $request
     *
     * @param                             $league_id
     *
     * @return array
     */
    public function store(CreateLeaguePasscodeRequest $request, $league_id)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $passcode = $this->dispatchFrom(CreateLeaguePasscodeCommand::class, $request, ['league_id' => $league_id, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leaguePasscodeTransformer->transform($passcode)
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePasscodeLength $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (LeaguePasscodeAlreadyCreated $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
