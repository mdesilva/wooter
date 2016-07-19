<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\Organization\League\CreateLeaguePasscodeCommand;
use Wooter\Http\Requests\Organization\League\CreateLeaguePasscodeRequest;
use Wooter\Wooter\Transformers\Organization\League\LeaguePasscodeTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class LeagueOrganizationPasscodeInvitesController extends Controller
{
    /**
     * @var LeaguePasscodeTransformer
     */
    private $LeaguePasscodeTransformer;

    /**
     * @param LeaguePasscodeTransformer $LeaguePasscodeTransformer
     */
    public function __construct(LeaguePasscodeTransformer $LeaguePasscodeTransformer) {

        $this->middleware('jwt.auth');
        $this->middleware('user.is_organization');
        $this->LeaguePasscodeTransformer = $LeaguePasscodeTransformer;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @api               {get} api/leagues/:leagueId/passcode-invite Create
     *  @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Team Passcode Invitation
     * @apiDescription    Create a team passcode invitation
     *
     * @apiParam {Number} leagueId Id of the league
     * @apiParam {String} passCode Passcode 
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": ['success' => 'Player invited for the league']
     *     }
     *
     * @param CreateLeaguePasscodeRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeaguePasscodeRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $leagueInvite = $this->dispatchFrom(CreateLeaguePasscodeCommand::class, $request, ['user_id' => $user_id]);

            return $this->respond([
                'data' => ['success' => 'Player invited for the league']
            ]);

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
