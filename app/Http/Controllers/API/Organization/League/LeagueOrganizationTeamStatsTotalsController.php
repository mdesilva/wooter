<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueTeamStatsCommand;
use Wooter\Wooter\Transformers\Team\TeamStatsTotalsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class LeagueOrganizationTeamStatsTotalsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $teamStatsTotalsTransformer;
    
    public function __construct(TeamStatsTotalsTransformer $teamStatsTotalsTransformer)
    {
        $this->teamStatsTotalsTransformer = $teamStatsTotalsTransformer;
        
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
     * @api               {get} api/leagues/:leagueId/team-stats-totals Index
     * @apiVersion        1.0.0
     * @apiName           Team Stats Totals
     * @apiGroup          Team Stats Totals
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Returns that stats totals of teams in a league
     *
     * @apiParam {Integer} leagueId The id of the league that the team stats belong to.
     * @apiParam {Integer} [offset] The amount to offset the results by.
     * @apiParam {Integer} [limit] The amount to limit the results by.
     * @apiParam {String} [order_by] The parameter to order the results by.
     * @apiParam {String} [order_direction] The direction to order the results in.
     * @apiParam {String} sport The sport that the stats belong to.
     * @apiParam {String} [type] The type of the stats.
     * @apiParam {String} [bulk] Notifies the api whether or not to return the results in bulk.
     * @apiParam {Integer} [team_id] The id of the competition that the stats belong to.
     * @apiParam {Integer} [season_id] The id of the game tgat the stats belong to.
     * @apiParam {Integer} [stage_id] The id of the team that tge stats belong to.
     * @apiParam {Integer} [game_id] The id of the player tgat the stats belong to.
     *
     * @apiSuccess        Object TeamStatsTotals
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => [
     *              'stats' => [
     *                  'first_quarter_points' => 0,
                        'second_quarter_points' => 0,
                        'third_quarter_points' => 0,
                        'fourth_quarter_points' => 0,
                        'points' => 0,
                        'wins' => 0,
                        'loss' => 0,
                        'draw' => 0,
                        'GB' => 0
     *              ],
     *              'team_id' => 1,
     *              'team_name' => 'Bears',
     *              'team_logo' => 'path/to/logo',
     *              'team_logo_thumbnail' => 'path/to/logo_thumbnail',
     *              'team_divisions' => [
     *                  [
     *                      'name' => 'North Division'
     *                  ]
     *              ]
     *          ]
     *     }
     *
     *
     * @param Request $request, $leagueId
     *
     * @return JsonResponse
     */

    public function index(Request $request, $leagueId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        $type = $request->input('type');
        $bulk = $request->input('bulk');
        
        $defaultRequest = [
            'leagueId' => $leagueId,
            'limit' => $request->input('limit', ApiController::DEFAULT_LIMIT),
            'offset' => $request->input('offset', ApiController::DEFAULT_OFFSET),
            'order_by' => $request->input('order_by', ApiController::DEFAULT_ORDER_BY),
            'order_direction' => $request->input('order_direction', ApiController::DEFAULT_ORDER_DIRECTION),
            'team_id' => $request->input('team_id', null),
            'season_id' => $request->input('season_id', null),
            'stage_id' => $request->input('stage_id', null),
            'game_id' => $request->input('game_id', null),
            'type' => $type
        ];
        
        $emptyRequest = [
            'leagueId' => $leagueId,
            'limit' => ApiController::DEFAULT_LIMIT,
            'offset' => ApiController::DEFAULT_OFFSET,
            'order_by' => ApiController::DEFAULT_ORDER_BY,
            'order_direction' => ApiController::DEFAULT_ORDER_DIRECTION,
            'team_id' => '',
            'season_id' => '',
            'stage_id' => '',
            'game_id' => '',
            'type' => ''
        ];
        
        try {
            $result = $this->dispatchFromArray(ReadLeagueTeamStatsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'leagueId' => $leagueId, 'request' => $defaultRequest]);

            $all = $this->dispatchFromArray(ReadLeagueTeamStatsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'leagueId' => $leagueId, 'request' => $emptyRequest]);

            $this->teamStatsTotalsTransformer->all = $all['stats'];
            $this->teamStatsTotalsTransformer->sport = $sport;
            $this->teamStatsTotalsTransformer->collection = true;
            $this->teamStatsTotalsTransformer->bulk = $bulk;
            
            return $this->respond([
                'data' => $this->teamStatsTotalsTransformer->transform($result['stats']),
                'pages' => $result['pages']
            ]);
        } catch (Exception $ex) {
        }
    }

    public function store(CreateTeamStatRequest $request)
    {
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    /**
     * @param $id
     */
    public function edit($id)
    {
    }
    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $teamId, $gameId)
    {
        
    }
    
    public function destroy() 
    {
        
    }
}

