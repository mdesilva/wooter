<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Organization\League\CreateLeagueSeasonGameStatsRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueSeasonGameStatsRequest;
use Wooter\Commands\Organization\League\CreateLeagueSeasonGameStatsCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueGamesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class LeagueSeasonGameStatsController extends Controller
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
            'show',
        ]]);
    }

    /**
     * @api               {post} api/leagues/:leagueId/season-game-stats Create
     * @apiVersion        1.0.0
     * @apiName           Create a new league
     * @apiGroup          League Season Game Stats
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Creates season stats for the specified league
     *
     * @apiParam {Number} id Id of the league
     * @apiParam {Number} season_id ID of the season of the league
     * @apiParam {Number} game_id ID of the game of the league
     * @apiParam {Number} home_team_points Points of the home team
     * @apiParam {Number} visiting_team_points Points of the visting team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'location' => 'Miss Bonnie Champlin',
     *                  'datetime' => '2016-05-10 06:58:46',
     *                  'date' => '2016-05-10 06:58:46',
     *                  'competition_id' => 1,
     *                  'competition_type' => 'Finals',
     *                  'league_id' => 1,
     *                  'sport' => 'Football',
     *                  'home_team' => 'Real Madrid',
     *                  'visiting_team' => 'Barcelona',
     *                  'home_team_id' => 1,
     *                  'visiting_team_id' => 2,
     *                  'home_team_score' => 2,
     *                  'visiting_team_score' => 2,
     *                  'home_team_logo' => $league_photos,
     *                  'home_team_logo_id' => 8,
     *                  'visiting_team_logo' => $league_qnapVideos,
     *                  'visiting_team_logo_id' => 10,
     *                  'week' => 'Tuesday',
     *              ]
     *     }
     *
     * @param CreateLeagueSeasonGameStatsRequest $request, $id, $season_id, $game_id
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueSeasonGameStatsRequest $request, $id, $season_id, $game_id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $game = $this->dispatchFrom(CreateLeagueSeasonGameStatsCommand::class, $request, ['userId' => $user_id, 'league_id' => $id, 'season_id' => $season_id, 'game_id' => $game_id]);

            return $this->respond([
                'data' => $this->leagueGamesTransformer->transform($game)
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
    public function show($id, $season_id, $game_id)
    {
        $team_id = Request::get('team_id');
        
        try {
            //$user = JWTAuth::parseToken()->authenticate();
            //$user_id = $user->id;
            $success = $this->dispatchFromArray(DeleteLeagueSeasonGameStatsCommand::class, ['user_id' => 1, 'league_id' => $id, 'season_id' => $season_id, 'game_id' => $game_id, 'team_id' => $team_id]);

            return $this->respond([
                        'data' => $success
            ]);
        } catch (Exception $ex) {
            
        }
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $season_id, $game_id)
    {

    }

    /** eturn \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLeagueSeasonGameStatsRequest $request, $id, $season_id, $game_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $game = $this->dispatchFrom(UpdateLeagueSeasonGameStatsCommand::class, $request, ['userId' => $user->id, 'league_id' => $id, 'season_id' => $season_id, 'game_id' => $game_id]);

            return $this->respond([
                'data' => $this->leagueGamesTransformer->transform($game)
            ]);
            
        } catch (Exception $ex) {

        }
    }
}
