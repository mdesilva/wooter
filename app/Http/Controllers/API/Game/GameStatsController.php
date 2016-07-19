<?php

namespace Wooter\Http\Controllers\API\Game;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Game\CreateGameStatRequest;
use Wooter\Commands\Game\CreateGameStatsCommand;
use Wooter\Commands\Game\ReadGameStatsCommand;
use Wooter\Commands\Game\DeleteGameStatsCommand;
use Wooter\Wooter\Transformers\Player\PlayerStatsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class GameStatsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $playerStatsTransformer;
    
    public function __construct(PlayerStatsTransformer $playerStatsTransformer)
    {
        $this->playerStatsTransformer = $playerStatsTransformer;
        
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
     * @api               {get} api/games/:gameId/player-stats Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiGroup          Game Stats
     * @apiDescription    Returns the stats for a Game
     *
     * @apiParam {Integer} gameId The id of the game that the returned stats should belong to.
     * @apiParam {Integer} [offset] The offset value of the request.
     * @apiParam {Integer} [limit] The limit amount of stats to return.
     * @apiParam {String} [order_by] The parameter to order that stats by.
     * @apiParam {String} [order_direction] The order direction of the stats.
     * @apiParam {String} sport The name of the sport of the stats to return.
     * @apiParam {String} [type] The type of stats to return.
     * @apiParam {String} [verbose] Notifies the api whether pr not to return a verbose response.
     * @apiParam {Integer} [player_id] The id of the player that the returned stats should belong to.
     * @apiParam {Integer} [pick] The index pf the stats to return.
     *
     * @apiSuccess Object GameStats
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
                        'player_id' => 123,
                        'team_id' => 14,
                        'name' => 'Michael Jordan',
                        'jersey' => 23,
                        'active' => 1,
                        'activate' => 0,
                        'deactivate' => 0,
                        'minutes' => 0,
                        'PTS' => 0,
                        '3FG' => 0,
                        '3FGA' => 0,
                        'AST' => 0,
                        'BLK' => 0,
                        'FG' => 0,
                        'FGA' => 0,
                        'FL' => 0,
                        'FT' => 0,
                        'FTA' => 0,
                        'STL' => 0,
                        'TURN' => 0,
                        'OFFRB' => 0,
                        'DEFRB' => 0
     *              },
     *              {
     *                  'id' => 2,
     *                  'player_id' => 53,
     *                  'team_id' => 5,
     *                  'jersey' => '2',
     *                  'PTS' => 0,
     *                  '3FG' => 0,
     *                  '3FGA' => 0,
     *                  'AST' => 0,
     *                  'BLK' => 0,
     *                  'FG' => 0,
     *                  'FG_percent' => 0,
     *                  'FGA' => 0,
     *                  'FL' => 0,
     *                  'FT' => 0,
     *                  'FTA' => 0,
     *                  'RBO' => 0,
     *                  'RBT' => 0,
     *                  'STL' => 0,
     *                  'TURN' => 0
     *              }
     *          ]
     *     }
     *
     *
     * @param Request $request, $gameId
     *
     * @return JsonResponse
     */
    public function index(Request $request, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        $type = $request->input('type', 'all');
        $verbose = $request->input('verbose', 'false');
        
        $requestParams = [
            'limit' => $request->input('limit', ApiController::DEFAULT_LIMIT),
            'offset' => $request->input('offset', ApiController::DEFAULT_OFFSET),
            'orderBy' => $request->input('order_by', ApiController::DEFAULT_ORDER_BY),
            'orderDirection' => $request->input('order_direction', ApiController::DEFAULT_ORDER_DIRECTION),
            'sport' => $sport,
            'type' => $type,
            'playerId' => $request->input('player_id', null),
            'pick' => $request->input('pick', null)
        ];
        
        try {
            $stats = $this->dispatchFromArray(ReadGameStatsCommand::class, ['userId' => $user->id, 'gameId' => $gameId, 'request' => $requestParams]);

            $this->playerStatsTransformer->sport = $sport;
            $this->playerStatsTransformer->type = $type ? $type : 'all';
            $this->playerStatsTransformer->verbose = $verbose;
            
            return $this->respond([
                'data' => $this->playerStatsTransformer->transform($stats)
            ]);
        } catch (Exception $ex) {
        }
    }
    /**
     * @api               {post} api/games/:gameId/player-stats Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          Game Stats
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Creates the stats of a game
     *
     * @apiParam {Integer} gameId The id of the game that the stats will belong to
     * @apiParam {String} method The method that was used to save the stats of the game.
     * @apiParam {String} sport The sport of the game that the stats belong to.
     * @apiParam {String} [type] The type of the stats
     * @apiParam {String} [verbose] Notifies the api whether or not to return a verbose response.
     * @apiParam {Object} request Object containing the stats of the game
     *
     * @apiSuccess        Object GameStats
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
                    'player_id' => 123,
                    'team_id' => 14,
                    'name' => 'Michael Jordan',
                    'jersey' => 23,
                    'active' => 1,
                    'activate' => 0,
                    'deactivate' => 0,
                    'minutes' => 0,
                    'PTS' => 0,
                    '3FG' => 0,
                    '3FGA' => 0,
                    'AST' => 0,
                    'BLK' => 0,
                    'FG' => 0,
                    'FGA' => 0,
                    'FL' => 0,
                    'FT' => 0,
                    'FTA' => 0,
                    'STL' => 0,
                    'TURN' => 0,
                    'OFFRB' => 0,
                    'DEFRB' => 0
     *          ]
     *     }
     *
     *
     * @param CreateGameStatRequest $request, $gameId
     *
     * @return JsonResponse
     */
    public function store(CreateGameStatRequest $request, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $method = $request->input('method');
        $sport = $request->input('sport');
        $type = $request->input('type');
        $verbose = $request->input('verbose', 'false');
        
        try {
            $stats = $this->dispatchFromArray(CreateGameStatsCommand::class, ['userId' => $user->id, 'gameId' => $gameId, 'method' => $method, 'sport' => $sport, 'type' => $type, 'request' => $request->all()]);

            $this->playerStatsTransformer->sport = $sport;
            $this->playerStatsTransformer->type = $type ? $type : 'all';
            $this->playerStatsTransformer->verbose = $verbose;
            
            return $this->respond([
                'data' => $this->playerStatsTransformer->transform($stats)
            ]);
        } catch (Exception $ex) {
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update()
    {
        //
    }
    
    public function destroy(Request $request, $leagueId, $gameId) 
    {
        
    }

    /**
     * @api               {delete} api/games/:gameId/player-stats Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          Game Stats
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Deletes the stats of a game
     *
     * @apiParam {Integer} gameId The id of the game that the stats will belong to.
     * @apiParam {String} sport The sport of the game that the stats belong to.
     * @apiParam {String} [type] The type of the stats
     *
     * @apiSuccess        Object GameStats
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 1
     *     }
     *
     *
     * @param CreateGameStatRequest $request, $gameId
     *
     * @return JsonResponse
     */
    public function deleteByGameId(Request $request, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        $type = $request->input('type');
        
        try {
            $success = $this->dispatchFromArray(DeleteGameStatsCommand::class, ['userId' => $user->id, 'gameId' => $gameId, 'sport' => $sport, 'type' => $type]);
 
            return $this->respond([
                'data' => $success
            ]);
        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }
}