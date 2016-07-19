<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\Organization\League\ReadLeaguePlayerStatsCommand;
use Wooter\Wooter\Transformers\Player\PlayerStatsAveragesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class LeagueOrganizationPlayerStatsAveragesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $averagesTransformer;
    
    public function __construct(PlayerStatsAveragesTransformer $averagesTransformer)
    {
        $this->averagesTransformer = $averagesTransformer;
        
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
     * @api               {get} api/leagues/:leagueId/player-stats-averages Index
     * @apiVersion        1.0.0
     * @apiName           Player Stats Averages
     * @apiGroup          Player Stats Averages
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Returns that stats averages of players
     *
     * @apiParam {Integer} leagueId The id of the league that the player stats belong to.
     * @apiParam {Integer} [offset] The amount to offset the results by.
     * @apiParam {Integer} [limit] The amount to limit the results by.
     * @apiParam {String} [order_by] The parameter to order the results by.
     * @apiParam {String} [order_direction] The direction to order the results in.
     * @apiParam {String} sport The sport that the stats belong to.
     * @apiParam {String} [type] The type of the stats.
     * @apiParam {String} [stat_name] The name of a single stat to return.
     * @apiParam {String} [bulk] Notifies the api whether or not to return the results in bulk.
     * @apiParam {Integer} [competition_id] Tge id of the competition that the stats belong to.
     * @apiParam {Integer} [game_id] The id of the game tgat the stats belong to.
     * @apiParam {Integer} [team_id] The id of the team that tge stats belong to.
     * @apiParam {Integer} [player_id] The id of the player tgat the stats belong to.
     *
     * @apiSuccess        Object PlayerStatsAverages
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => [
     *              'all' => [
     *                  [
     *                      'averages' => [
                                'PPG' => 0,
                                'FG' => 0,
                                'FGA' => 0,
                                '3FG' => 0,
                                '3FGA' => 0,
                                'FT' => 0,
                                'FTA' => 0,
                                'OFFR' => 0,
                                'DEFR' => 0,
                                'AST' => 0,
                                'TURN' => 0,
                                'STL' => 0,
                                'BLK' => 0,
                                'FL' => 0,
                                'total_games' => 0,
                                'PPG_rank' => 0,
                                'FG_rank' => 0,
                                '3FG_rank' => 0,
                                '3FGA_rank' => 0,
                                'FT_rank' => 0,
                                'FTA_rank' => 0,
                                'OFFR_rank' => 0,
                                'DEFR_rank' => 0,
                                'AST_rank' => 0,
                                'TURN_rank' => 0,
                                'STL_rank' => 0,
                                'BLK_rank' => 0,
                                'FL_rank' => 0
                            ],
                            'name' => 'Michael Jordan',
                            'jersey' => 23,
                            'player_id => 1
     *                  ]
     *              ]
     *          ]
     *     }
     *
     *
     * @param CreateGameStatRequest $request, $gameId
     *
     * @return JsonResponse
     */

    public function index(Request $request, $leagueId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        $type = $request->input('type', null);
        $stat_name = $request->input('statName', null);
        $bulk = $request->input('bulk');
        
        $requestParams = [
            'leagueId' => $request->input('league_id', null),
            'competitionId' => $request->input('competition_id', null),
            'gameId' => $request->input('game_id', null),
            'teamId' => $request->input('team_id', null),
            'playerId' => $request->input('player_id', null),
            'offset' => $request->input('offset', ApiController::DEFAULT_OFFSET),
            'limit' => $request->input('limit', ApiController::DEFAULT_LIMIT),
            'orderBy' => $request->input('order_by', ApiController::DEFAULT_ORDER_BY),
            'orderDirection' => $request->input('order_direction', ApiController::DEFAULT_ORDER_DIRECTION)
        ];
        
        try {
            $stats = $this->dispatchFromArray(ReadLeaguePlayerStatsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'type' => $type, 'leagueId' => $leagueId, 'request' => $requestParams]);
            
            $defaultParams = [
                'leagueId' => $leagueId,
                'competitionId' => '',
                'gameId' => '',
                'teamId' => '',
                'playerId' => '',
                'offset' => 0,
                'limit' => 'all',
                'orderBy' => '',
                'orderDirection' => ''
            ];
            
            $all = $this->dispatchFromArray(ReadLeaguePlayerStatsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'type' => $type, 'leagueId' => $leagueId, 'request' => $defaultParams]);

            $this->averagesTransformer->sport = $sport;
            $this->averagesTransformer->type = $type ? $type : 'all';
            $this->averagesTransformer->stat_name = $stat_name;
            $this->averagesTransformer->all = $all;
            
            $data = [];
            
            foreach ($stats as $type => $stat) {
                if ($type !== 'pages') {
                    $data[$type] = [];
                }
            }
            
            switch($bulk) {
                case 'true':
                    foreach($stats as $type => $stat) {
                        if ($type !== 'pages') {
                            $this->averagesTransformer->type = $type;
                            $data[$type][] = $this->averagesTransformer->transform($stat);
                        }
                        
                    }
                    break;
                case 'false':
                    foreach ($stats as $type => $stat) {
                        if ($type !== 'pages') {
                            $uniqueIds = [];
                            $allIds = $stat->lists('player_id');
                            foreach ($allIds as $id) {
                                if ($id > 0) {
                                    $uniqueIds[$id] = $id;
                                }
                            }
                            foreach ($uniqueIds as $id) {
                                $playerStats = $stat->where('player_id', $id);
                                $this->averagesTransformer->all[$type];
                                $this->averagesTransformer->type = $type;
                                $data[$type][] = [
                                    'averages' => $this->averagesTransformer->transform($playerStats),
                                    'name' => $playerStats->first()->name,
                                    'jersey' => $playerStats->first()->jersey,
                                    'player_id' => $playerStats->first()->player_id
                                ];
                            }
                        }
                        
                    }
            }
            
            return $this->respond([
                'data' => $data,
                'pages' => $stats['pages']
            ]);
        } catch (Exception $ex) {
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
    public function update()
    {
        //
    }
    
    public function destroy(Request $request, $leagueId, $gameId) 
    {
        
    }
}

