<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Organization\League\CreateLeagueCompetitionWeekRequest;
use Wooter\Commands\Organization\League\CreateLeagueCompetitionWeekCommand;
use Wooter\Commands\Organization\League\ReadLeagueCompetitionWeeksCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueCompetitionWeeksTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;

final class LeagueCompetitionWeeksController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $leagueCompetitionWeeksTransformer;
    
    public function __construct(LeagueCompetitionWeeksTransformer $leagueCompetitionWeeksTransformer) 
    {
        $this->leagueCompetitionWeeksTransformer = $leagueCompetitionWeeksTransformer;
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
     * @api               {get} api/leagues/:leagueId/competition/:competitionId/weeks Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Competition Weeks
     * @apiPermission     organization, JWT
     * @apiDescription    Returns the basic information for the requested competition of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} competitionId Competition id of the competition.
     *
     * @apiSuccess Object LeagueCompetitionWeeks
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'competition_id' => 3,
     *                  'competition_type' => 'Finals',
     *                  'name' => 'NBA',
     *                  'start_date' => '2016-05-10 06:58:46',
     *                  'end_date' => '2016-05-10 06:58:46'
     *              },
     *              {
     *                  'id' => 2,
     *                  'competition_id' => 4,
     *                  'competition_type' => 'Semi-Finals',
     *                  'name' => 'NBA',
     *                  'start_date' => '2016-05-10 06:58:46',
     *                  'end_date' => '2016-05-10 06:58:46'
     *              }
     *          ]
     *     }
     *
     * @param $leagueId, $competitionId
     *
     * @return JsonResponse
     */

    public function index($leagueId, $competitionId)
    {   
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $request = Request::all();
            $weeks = $this->dispatchFromArray(ReadLeagueCompetitionWeeksCommand::class, ['userId' => $user->id, 'leagueId' => $leagueId, 'competitionId' => $competitionId, 'params' => new RequestObject($request)]);

            return $this->respond([
                'data' => $this->leagueCompetitionWeeksTransformer->transformCollection($weeks)
                    ]);
            
        } catch (Exception $ex) {
            return $this->respondInternalError($e->getMessage());
        }
    }
    
    /**
     * @api               {post} api/leagues/:leagueId/competition/:competitionId/weeks Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Competition Weeks
     * @apiPermission     organization, JWT
     * @apiDescription    Creates a new League Competition week for the League Competition
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} competitionId Competition id of the competition.
     * @apiParam {String} competition_type Type of the competition.
     * @apiParam {String} name Name of the competition week.
     * @apiParam {String} start_date Start date of the competition week.
     * @apiParam {String} end_date End date of the competition week.
     *
     * @apiSuccess Object LeagueCompetitionWeeks
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'competition_id' => 3,
     *              'competition_type' => 'Finals',
     *              'name' => 'NBA',
     *              'start_date' => '2016-05-10 06:58:46',
     *              'end_date' => '2016-05-10 06:58:46'
     *              ],
     *          ]
     *     }
     *
     *
     * @param CreateLeagueCompetitionWeekRequest $request, $leagueId, $competitionId
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueCompetitionWeekRequest $request, $leagueId, $competitionId)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $week = $this->dispatchFrom(CreateLeagueCompetitionWeekCommand::class, $request, ['userId' => $user->id, 'league_id' => $leagueId, 'competition_id' => $competitionId]);

            return $this->respond([
                'data' => $this->leagueCompetitionWeeksTransformer->transform($week)
                    ]);
            
        } catch (Exception $ex) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /** eturn \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }
}
