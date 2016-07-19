<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Organization\League\CreateLeagueGameRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueGameRequest;
use Wooter\Commands\Organization\League\ReadLeagueGameCommand;
use Wooter\Commands\Organization\League\ReadLeagueGamesCommand;
use Wooter\Commands\Organization\League\CreateLeagueGameCommand;
use Wooter\Commands\Organization\League\UpdateLeagueGameCommand;
use Wooter\Commands\Organization\League\DeleteLeagueGameCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueGamesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Input;

final class LeagueOrganizationGamesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $leagueGamesTransformer;
    
    public function __construct(LeagueGamesTransformer $leagueGamesTransformer)
    {
        $this->leagueGamesTransformer = $leagueGamesTransformer;
        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'leagueGames',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/games Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Games
     * @apiDescription    Returns an array of all the league games that match the filter parameters
     *
     * @apiSuccess {Array} data Array with all the league games.
     *
     * @apiParam {Integer} [offset] Indicates how much to offset the games when retrieving the games from the database
     * @apiParam {Integer} [limit] The max nimber of games that will be queried
     * @apiParam {String} [orderBy] The parameter to order the games by
     * @apiParam {String} [orderDirection] The order direction of the games
     * @apiParam {Integer} [teamId] The id of the team that should belong to all games returned
     * @apiParam {Integer} [playerId] The id of the player that should belong to all games returned
     * @apiParam {Integer} [seasonId] The id of the season that all games returned should belong to
     * @apiParam {Integer} [divisionId] The id of the division that all games returned should belong to
     * @apiParam {Integer} [weekId] The id of the week that the games should belong to
     * @apiParam {String} [all] Notifies the api whether or not to return all games without a limit
     * @apiParam {Integer} [competitionId] The id of the week that the games will belong to
     * @apiParam {String} [competitionType] The id of the competition that all games returned should belong to
     * @apiParam {Integer} [pick] The index of the game that should be returned
     * @apiParam {String} [game_status] The status of the games that should be returned
     * @apiParam {String} [scored] Notifies the api whether or not to return scored games
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => $game_id,
                        'game_venue' => $game_venue,
                        'location' => $game_location,
                        'datetime' => $game_time,
                        'date' => $game_date,
                        'stage_id' => $game_stage_id,
                        'stage_type' => $game_stage_type,
                        'competition_id' => $game_competition_id,
                        'competition_type' => $game_competition_type,
                        'organization_id' => $game_organization_id,
                        'organization_type' => $game_organization_type,
                        'sport' => $game_sport,
                        'home_team' => $game_home_team,
                        'visiting_team' => $game_visiting_team,
                        'home_team_id' => $game_home_team_id,
                        'visiting_team_id' => $game_visiting_team_id,
                        'home_team_score' => $game_home_team_score,
                        'visiting_team_score' => $game_visiting_team_score,
                        'home_team_win' => $game_home_team_win,
                        'visiting_team_win' => $game_visiting_team_win,
                        'home_team_loss' => $game_home_team_loss,
                        'visiting_team_loss' => $game_visiting_team_loss,
                        'home_team_draw' => $game_home_team_draw,
                        'visiting_team_draw' => $game_visiting_team_draw,
                        'home_team_logo' => $game_home_team_logo,
                        'home_team_logo_id' => $game_home_team_logo_id,
                        'visiting_team_logo' => $game_visiting_team_logo,
                        'visiting_team_logo_id' => $game_visiting_team_logo_id,
                        'week' => $game_week,
                        'time' => $game_time,
                        'day' => $game_time_day,
                        'month' => $game_time_month,
                        'year' => $game_time_year,
                        'hour' => $game_time_hour,
                        'minute' => $game_time_minute,
                        'second' => $game_time_second,
                        'created_at' => $game_created_at,
                        'updated_at' => $game_updated_at,
                        'scored' => $game_scored,
                        'game_status' => $game_status
     *              ]
     *          ]
     *     }
     *
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */

    public function index($leagueId)
    {
        
        try {
            $request = Request::all();
            $playerId = Request::get('playerId', null);
            $pick = Request::get('pick');
            $result = $this->dispatchFromArray(ReadLeagueGamesCommand::class, ['leagueId' => $leagueId, 'request' => new RequestObject($request)]);

            $this->leagueGamesTransformer->playerId = ($playerId && ($pick || $pick === '0') ) ? $playerId : false;
            return $this->respond([
                'data' => ['games' => $this->leagueGamesTransformer->transformCollection($result['games']), 'pages' => $result['pages']]
            ]);

        } catch (Exception $e) {
            var_dump($e->getLine(), $e->getMessage(), $e->getFile());
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/games Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Game
     * @apiDescription    Returns an array of information belonging to a league game
     *
     * @apiSuccess {Array} data Array with information about a league game.
     *
     * @apiParam {integer} [home_team_id] The id of the home team
     * @apiParam {integer} [visiting_team_id] The id of the visiting team
     * @apiParam {integer} [location_id] The id of the location where the game will be played
     * @apiParam {integer} [game_structure_id] The id of the game structure for the game
     * @apiParam {integer} [sport_id] The id of the sport of the game
     * @apiParam {integer} [home_team_score] The score of the home team
     * @apiParam {integer} [visiting_team_score] The score of the visiting team
     * @apiParam {integer} [competition_id] The id of the competition that the game belongs to
     * @apiParam {string} [competition_type] The type of the competition that the game belongs to
     * @apiParam {integer} [stats_id] The id of the stats of the game
     * @apiParam {string} [stats_type] The type of the stats of the game
     * @apiParam {integer} [week_id] The id of the week that the game belongs to
     * @apiParam {timestamp} [time] The time of the game
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => 1,
     *                  'location' => $game_location,
     *                  'datetime' => $game_datetime,
     *                  'date' => $game_date,
     *                  'competition_id' => $game_competition_id,
     *                  'competition_type' => $game_competition_type,
     *                  'league_id' => $game_league_id,
     *                  'home_team' => $game_home_team,
     *                  'visiting_team' => $game_visiting_team,
     *                  'home_team_id' => $game_home_team_id,
     *                  'visiting_team_id' => $game_visiting_team_id,
     *                  'home_team_score' => $game_home_team_score,
     *                  'visiting_team_score' => $game_visiting_team_score,
     *                  'home_team_logo' => $game_home_team_logo,
     *                  'home_team_logi_id' => $game_home_team_logo_id,
     *                  'visiting_team_logo' => $game_visiting_team_logo,
     *                  'visiting_team_logo_id' => $game_visiting_team_logo_id,
     *                  'week' => $game_week
     *              ]
     *          ]
     *     }
     *
     *
     * @param CreateLeagueGameRequest $request
     *
     * @return JsonResponse
     */
    
    public function store(CreateLeagueGameRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $game = $this->dispatchFrom(CreateLeagueGameCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $game ? $this->leagueGamesTransformer->transform($game) : false
            ]);
            
        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());

        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/games/:gameId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Game
     * @apiDescription    Returns an array of information belonging to a league game
     *
     * @apiSuccess {Array} data Array with information about a league game.
     *
     * @apiParam {integer} [leagueId] The id of the league of the game
     * @apiParam {integer} [gameId] The id of the game
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => 1,
     *                  'location' => $game_location,
     *                  'datetime' => $game_datetime,
     *                  'date' => $game_date,
     *                  'competition_id' => $game_competition_id,
     *                  'competition_type' => $game_competition_type,
     *                  'league_id' => $game_league_id,
     *                  'home_team' => $game_home_team,
     *                  'visiting_team' => $game_visiting_team,
     *                  'home_team_id' => $game_home_team_id,
     *                  'visiting_team_id' => $game_visiting_team_id,
     *                  'home_team_score' => $game_home_team_score,
     *                  'visiting_team_score' => $game_visiting_team_score,
     *                  'home_team_logo' => $game_home_team_logo,
     *                  'home_team_logi_id' => $game_home_team_logo_id,
     *                  'visiting_team_logo' => $game_visiting_team_logo,
     *                  'visiting_team_logo_id' => $game_visiting_team_logo_id,
     *                  'week' => $game_week
     *              ]
     *          ]
     *     }
     *
     *
     * @param $leagueId
     * @param $gameId
     *
     * @return JsonResponse
     */
    public function show($leagueId, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $game = $this->dispatchFromArray(ReadLeagueGameCommand::class, ['userId' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);

            return $this->respond([
                'data' => $this->leagueGamesTransformer->transform($game)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    
    public function edit($leagueId, $gameId)
    {

    }

    /**
     * @api               {get} api/leagues/:leagueId/games/:gameId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Game
     * @apiDescription    Returns an array of information belonging to a league game
     *
     * @apiSuccess {Array} data Array with information about a league game.
     *
     * @apiParam {integer} [home_team_id] The id of the home team
     * @apiParam {integer} [visiting_team_id] The id of the visiting team
     * @apiParam {integer} [location_id] The id of the location where the game will be played
     * @apiParam {integer} [game_structure_id] The id of the game structure for the game
     * @apiParam {integer} [sport_id] The id of the sport of the game
     * @apiParam {integer} [home_team_score] The score of the home team
     * @apiParam {integer} [visiting_team_score] The score of the visiting team
     * @apiParam {integer} [competition_id] The id of the competition that the game belongs to
     * @apiParam {string} [competition_type] The type of the competition that the game belongs to
     * @apiParam {integer} [stats_id] The id of the stats of the game
     * @apiParam {string} [stats_type] The type of the stats of the game
     * @apiParam {integer} [week_id] The id of the week that the game belongs to
     * @apiParam {timestamp} [time] The time of the game
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => 1,
     *                  'location' => $game_location,
     *                  'datetime' => $game_datetime,
     *                  'date' => $game_date,
     *                  'competition_id' => $game_competition_id,
     *                  'competition_type' => $game_competition_type,
     *                  'league_id' => $game_league_id,
     *                  'home_team' => $game_home_team,
     *                  'visiting_team' => $game_visiting_team,
     *                  'home_team_id' => $game_home_team_id,
     *                  'visiting_team_id' => $game_visiting_team_id,
     *                  'home_team_score' => $game_home_team_score,
     *                  'visiting_team_score' => $game_visiting_team_score,
     *                  'home_team_logo' => $game_home_team_logo,
     *                  'home_team_logi_id' => $game_home_team_logo_id,
     *                  'visiting_team_logo' => $game_visiting_team_logo,
     *                  'visiting_team_logo_id' => $game_visiting_team_logo_id,
     *                  'week' => $game_week
     *              ]
     *          ]
     *     }
     *
     *
     * @param UpdateLeagueGameRequest $request
     * @param                         $leagueId
     * @param                         $gameId
     *
     * @return JsonResponse
     */
    public function update(UpdateLeagueGameRequest $request, $leagueId, $gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $game = $this->dispatchFrom(UpdateLeagueGameCommand::class, $request, ['userId' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);
            
            return $this->respond([
                'data' => $this->leagueGamesTransformer->transform($game)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/games/:gameId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Game
     * @apiDescription    Returns an array of information belonging to a league game
     *
     * @apiSuccess {Array} data Array with information about a league game.
     *
     * @apiParam {integer} [leagueId] The id of the league of the game
     * @apiParam {integer} [gameId] The id of the game
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": true
     *     }
     *
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function destroy($leagueId)
    {
        $gameId = Input::get("gameId");

        $user = JWTAuth::parseToken()->authenticate();

        try {
            $result = $this->dispatchFromArray(DeleteLeagueGameCommand::class, ['userId' => $user->id, 'league_id' => $leagueId, 'game_id' => $gameId]);

            return $this->respond([
                'data' => $result ? $gameId : false
            ]);
            
        } catch (Exception $ex) {

        }
    }
}
