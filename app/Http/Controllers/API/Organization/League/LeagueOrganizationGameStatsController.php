<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Organization\League\CreateLeagueGameBasketballStatRequest;
use Wooter\Commands\Organization\League\CreateLeagueGameBasketballStatByUploadCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameSoftballStatByUploadCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameFootballStatByUploadCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameBasketballStatCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameSoftballStatCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameFootballStatCommand;
use Wooter\Commands\Organization\League\ReadLeagueGameBasketballStatsCommand;
use Wooter\Commands\Organization\League\ReadLeagueGameSoftballStatsCommand;
use Wooter\Commands\Organization\League\ReadLeagueGameFootballStatsCommand;
use Wooter\Commands\Organization\League\DeleteLeagueGameBasketballStatsCommand;
use Wooter\Commands\Organization\League\DeleteLeagueGameSoftballStatsCommand;
use Wooter\Commands\Organization\League\DeleteLeagueGameFootballStatsCommand;
use Wooter\Wooter\Transformers\Player\PlayerBasketballStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerSoftballStatsTransformer;
use Wooter\Wooter\Transformers\Player\PlayerFootballStatsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;


class LeagueGameStatsController extends Controller
{
    use Responder, ApiDocErrorBlocs;

    private $playerBasketballStatsTransformer;
    private $playerSoftballStatsTransformer;
    private $playerFootballStatsTransformer;

    public function __construct(PlayerBasketballStatsTransformer $playerBasketballStatsTransformer,
                                PlayerSoftballStatsTransformer $playerSoftballStatsTransformer,
                                PlayerFootballStatsTransformer $playerFootballStatsTransformer)
    {
        $this->playerBasketballStatsTransformer = $playerBasketballStatsTransformer;
        $this->playerSoftballStatsTransformer = $playerSoftballStatsTransformer;
        $this->playerFootballStatsTransformer = $playerFootballStatsTransformer;

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
     * @api               {get} api/leagues/:leagueId/games/:gameId/player-stats Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiGroup          League Game Stats
     * @apiDescription    Returns the Game Stats for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} gameId Game id of the game.
     *
     * @apiSuccess        Object LeagueGameStats
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'player_id' => 53,
     *                  'team_id' => 5,
     *                  'jersey' => '0  Jordan',
     *                  'PTS' => '35',
     *                  '3FG' => '0',
     *                  '3FGA' => '0',
     *                  'AST' => '0',
     *                  'BLK' => '0',
     *                  'FG' => '0',
     *                  'FG_percent' => '0',
     *                  'FGA' => '0',
     *                  'FL' => '0',
     *                  'FT' => '0',
     *                  'FTA' => '0',
     *                  'RBO' => '0',
     *                  'RBT' => '0',
     *                  'STL' => '0',
     *                  'TURN' => '0'
     *              },
     *              {
     *                  'id' => 2,
     *                  'player_id' => 53,
     *                  'team_id' => 5,
     *                  'jersey' => '0  Jordan',
     *                  'PTS' => '35',
     *                  '3FG' => '0',
     *                  '3FGA' => '0',
     *                  'AST' => '0',
     *                  'BLK' => '0',
     *                  'FG' => '0',
     *                  'FG_percent' => '0',
     *                  'FGA' => '0',
     *                  'FL' => '0',
     *                  'FT' => '0',
     *                  'FTA' => '0',
     *                  'RBO' => '0',
     *                  'RBT' => '0',
     *                  'STL' => '0',
     *                  'TURN' => '0'
     *              }
     *          ]
     *     }
     *
     *
     * @param Request $request , $leagueId, $gameId
     *
     * @param         $leagueId
     * @param         $gameId
     *
     * @return JsonResponse
     */

    public function index(Request $request, $leagueId, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');

        try {
            switch($sport) {
                case 'Basketball':
                    $stats = $this->dispatchFromArray(ReadLeagueGameBasketballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);
                    $transformer = $this->playerBasketballStatsTransformer;
                    break;
                case 'Softball':
                    $stats = $this->dispatchFromArray(ReadLeagueGameSoftballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);
                    $transformer = $this->playerSoftballStatsTransformer;
                    break;
                case 'Football':
                    $stats = $this->dispatchFromArray(ReadLeagueGameFootballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);
                    $transformer = $this->playerFootballStatsTransformer;
                    break;
            }

            return $this->respond([
                'data' => $transformer->transformCollection($stats)
            ]);

        } catch (Exception $ex) {

        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/games/:gameId/player-stats Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Game Stats
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Creates a new Game Stat for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} gameId Game id of the game.
     * @apiParam {String} method Type of submission(form,upload)
     * @apiParam {String} sport Sport for which stat is to store.
     *
     * @apiSuccess        Object LeagueFeature
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'player_id' => 53,
     *              'team_id' => 5,
     *              'jersey' => '0  Jordan',
     *              'PTS' => '35',
     *              '3FG' => '0',
     *              '3FGA' => '0',
     *              'AST' => '0',
     *              'BLK' => '0',
     *              'FG' => '0',
     *              'FG_percent' => '0',
     *              'FGA' => '0',
     *              'FL' => '0',
     *              'FT' => '0',
     *              'FTA' => '0',
     *              'RBO' => '0',
     *              'RBT' => '0',
     *              'STL' => '0',
     *              'TURN' => '0',
     *          ]
     *     }
     *
     *
     * @param CreateLeagueGameBasketballStatRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueGameBasketballStatRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $method = $request->input('method');
        $sport = $request->input('sport');

        try {
            switch($method) {
                case 'upload':
                    switch($sport) {
                        case 'Basketball':
                            $stats = $this->dispatchFrom(CreateLeagueGameBasketballStatByUploadCommand::class, $request, ['user_id' => $user->id]);
                            break;
                        case 'Softball':
                            $stats = $this->dispatchFrom(CreateLeagueGameSoftballStatByUploadCommand::class, $request, ['user_id' => $user->id]);
                            break;
                        case 'Football':
                            $stats = $this->dispatchFrom(CreateLeagueGameFootballStatByUploadCommand::class, $request, ['user_id' => $user->id]);
                            break;
                    }
                    break;
                case 'form':
                    switch ($sport) {
                        case 'Basketball':
                            $stats = $this->dispatchFromArray(CreateLeagueGameBasketballStatCommand::class, ['user_id' => $user->id, 'data' => $request->all()]);
                            break;
                        case 'Softball':
                            $stats = $this->dispatchFrom(CreateLeagueGameSoftballStatCommand::class, $request, ['user_id' => $user->id]);
                            break;
                        case 'Football':
                            $stats = $this->dispatchFrom(CreateLeagueGameFootballStatCommand::class, $request, ['user_id' => $user->id]);
                            break;
                    }

                    break;
            }

            switch($sport) {
                case 'Basketball':
                    $transformer = $this->playerBasketballStatsTransformer;
                    break;
                case 'Softball':
                    $transformer = $this->playerSoftballStatsTransformer;
                    break;
                case 'Football':
                    $transformer = $this->playerFootballStatsTransformer;
                    break;
            }

            return $this->respond([
                'data' => $transformer->transformCollection($stats)
            ]);

        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
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

    /**
     * @api               {delete} api/leagues/:leagueId/games/:gameId/player-stats Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Game Stats
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Deletes the league game stat
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} gameId Game id of the game.
     * @apiParam {Number} team_id team id of the league
     * @apiParam {String} sport sport stat to delete
     * @apiParam {Number} gameId id of the game
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'true'
     *     }
     *
     * @param Request $request, $leagueId, $gameId
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, $leagueId, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $team_id = $request->input('team_id');
        $sport = $request->input('sport');
        try {
            switch($sport) {
                case 'Basketball':
                    $success = $this->dispatchFromArray(DeleteLeagueGameBasketballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId, 'team_id' => $team_id]);
                    break;
                case 'Softball':
                    $success = $this->dispatchFromArray(DeleteLeagueGameSoftballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId, 'team_id' => $team_id]);
                    break;
                case 'Football':
                    $success = $this->dispatchFromArray(DeleteLeagueGameFootballStatsCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId, 'team_id' => $team_id]);
                    break;
            }

            return $this->respond([
                'data' => $success
            ]);
        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
