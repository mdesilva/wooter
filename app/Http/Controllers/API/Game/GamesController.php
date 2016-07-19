<?php

namespace Wooter\Http\Controllers\API\Game;

use Exception;
use Illuminate\Http\JsonResponse;
use Wooter\Commands\Game\ReadGameCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Exceptions\GameNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\SportNotFound;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Http\Requests\Game\CreateGameRequest;
use Wooter\Http\Requests\Game\UpdateGameRequest;
use Wooter\Commands\Game\CreateGameCommand;
use Wooter\Commands\Game\UpdateGameCommand;
use Wooter\Commands\Game\DeleteGameCommand;
use Wooter\Wooter\Transformers\Game\GamesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class GamesController extends ApiController
{
    private $gamesTransformer;
    
    public function __construct(GamesTransformer $gamesTransformer)
    {
        $this->gamesTransformer = $gamesTransformer;

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
     * @api               {post} api/games Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          Game
     * @apiDescription    Creates a Game
     *
     * @apiSuccess {Array} data Array containing data that belongs to the newly created game
     *
     * @apiParam {Integer} home_team_id The id of the home team of the game
     * @apiParam {Integer} visiting_team_id The id of the visiting team of the game
     * @apiParam {String} game_venue_id The id of the venue where the game will take place
     * @apiParam {String} sport_id The id of the sport of the game
     * @apiParam {Integer} stage_id The id of the stage that the game belongs to
     * @apiParam {Integer} stage_type The type of the stage that tge game belongs to
     * @apiParam {Integer} time The scheduled time of the game
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
     * @param CreateGameRequest $request
     *
     * @return JsonResponse
     */

    public function store(CreateGameRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $game = $this->dispatchFrom(CreateGameCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->gamesTransformer->transform($game)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (GameNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/games/:gameId Show
     * @apiVersion        1.0.0
     * @apiName           Show
     * @apiGroup          Game
     * @apiDescription    Returns a Game
     *
     * @apiSuccess {Array} data Array with data belonging to a game
     * 
     * @apiParam {Integer} gameId The id of the game to be returned
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
     * @param $gameId
     *
     * @return JsonResponse
     */
    public function show($gameId)
    {
        try
        {
            $game = $this->dispatchFromArray(ReadGameCommand::class, ['game_id' => $gameId]);

            return $this->respond([
                'data' => $this->gamesTransformer->transform($game)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (GameNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    
    public function edit($gameId)
    {

    }
    
    /**
     * @api               {put} api/games/:gameId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          Game
     * @apiDescription    Updates a Game
     *
     * @apiSuccess {Array} data Array containing data that belongs to the updated game
     *
     * @apiParam {Integer} gameId The id of the game
     * @apiParam {Integer} home_team_id The id of the home team of the game
     * @apiParam {Integer} visiting_team_id The id of the visiting team of the game
     * @apiParam {String} game_venue_id The id of the venue where the game will take place
     * @apiParam {String} sport_id The id of the sport of the game
     * @apiParam {Integer} stage_id The id of the stage that the game belongs to
     * @apiParam {Integer} stage_type The type of the stage that tge game belongs to
     * @apiParam {Integer} time The scheduled time of the game
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
     * @param UpdateGameRequest $request, $gameId
     *
     * @return JsonResponse
     */

    public function update(UpdateGameRequest $request, $gameId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $game = $this->dispatchFrom(UpdateGameCommand::class, $request, ['user_id' => $user->id, 'game_id' => $gameId]);

            return $this->respond([
                'data' => $this->gamesTransformer->transform($game)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (GameNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (SportNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (RegularStageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
    
    /**
     * @api               {delete} api/games/:gameId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          Game
     * @apiDescription    Deletes a Game
     *
     * @apiSuccess {Integer} The id of the deleted game
     * 
     * @apiParam {Integer} gameId The id of the game to delete
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data" => 1
     *     }
     * 
     * @param $gameId
     *
     * @return JsonResponse
     */
    
    public function destroy($gameId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteGameCommand::class, ['user_id' => $user->id, 'game_id' => $gameId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (GameNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
