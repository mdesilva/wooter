<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Wooter\Commands\Organization\League\CreateLeagueDetailsCommand;
use Wooter\Commands\Organization\League\DeleteLeagueDetailsCommand;
use Wooter\Commands\Organization\League\ReadLeagueDetailsCommand;
use Wooter\Commands\Organization\League\UpdateLeagueDetailsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeagueDetailsRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueDetailsRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueDetailsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Transformers\Organization\League\LeagueDetailsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;


final class LeagueOrganizationDetailsController extends ApiController
{

    /**
     * @var LeagueDetailsTransformer
     */
    private $LeagueDetailsTransformer;

    /**
     * @param LeagueDetailsTransformer $LeagueDetailsTransformer
     */
    public function __construct(LeagueDetailsTransformer $LeagueDetailsTransformer) {

        $this->LeagueDetailsTransformer = $LeagueDetailsTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {post} api/leagues/:leagueId/details Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Details
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new League Details for the League
     *
     * @apiParam {Number} league_id League id of the league to save the basics to
     * @apiParam {Number="Existing game structure ID"} game_structure_id Game Structure of the League
     * @apiParam {Number="Existing playoff structure ID"} playoff_structure_id Playoff Structure of the League
     * @apiParam {Number="Existing season structure ID"} season_structure_id Season Structure of the League
     * @apiParam {Number} number_of_teams Number of teams
     * @apiParam {Number} players_per_team Number of player per team
     * @apiParam {Number} max_players Maximum number of players for a league
     * @apiParam {Number} game_duration The duration of the game in minutes
     * @apiParam {Number} time_period The time of each period of the match in minutes
     *
     * @apiSuccess        Object LeagueOrganizationDetails
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'league_id' => '6',
     *              'game_structure_id' => '5',
     *              'playoff_structure_id' => '3',
     *              'season_structure_id' => '4',
     *              'number_of_teams' => '25',
     *              'players_per_team' => '11',
     *              'max_players' => '25',
     *              'game_duration' => '90',
     *              'time_period' => '45',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeagueDetailsRequest $request
     * @param                            $leagueId
     *
     * @return array
     */
    public function store(CreateLeagueDetailsRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $leagueDetails = $this->dispatchFrom(CreateLeagueDetailsCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueDetailsTransformer->transform($leagueDetails)
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/details Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Details
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets the league details
     *
     * @apiParam {Number} LeagueId Id of the League
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'league_id' => '6',
     *                  'game_structure_id' => '5',
     *                  'playoff_structure_id' => '3',
     *                  'season_structure_id' => '4',
     *                  'number_of_teams' => '25',
     *                  'players_per_team' => '11',
     *                  'max_players' => '25',
     *                  'game_duration' => '90',
     *                  'time_period' => '45',
     *              }
     *          ]
     *     }
     *
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param $leagueId
     *
     * @return array
     */
    public function index($leagueId)
    {
        try
        {
            $leagueDetails = $this->dispatchFromArray(ReadLeagueDetailsCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueDetailsTransformer->transform($leagueDetails)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueDetailsNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/league_details Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Details
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league details
     *
     * @apiParam {Number="Existing game structure ID"} game_structure_id Game Structure of the League
     * @apiParam {Number="Existing playoff structure ID"} playoff_structure_id Playoff Structure of the League
     * @apiParam {Number="Existing season structure ID"} season_structure_id Season Structure of the League
     * @apiParam {Number} number_of_teams Number of teams
     * @apiParam {Number} players_per_team Number of player per team
     * @apiParam {Number} max_players Maximum number of players for a league
     * @apiParam {Number} game_duration The duration of the game in minutes
     * @apiParam {Number} time_period The time of each period of the match in minutes
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'league_id' => '6',
     *              'game_structure_id' => '5',
     *              'playoff_structure_id' => '3',
     *              'season_structure_id' => '4',
     *              'number_of_teams' => '25',
     *              'players_per_team' => '11',
     *              'max_players' => '25',
     *              'game_duration' => '90',
     *              'time_period' => '45',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param UpdateLeagueDetailsRequest $request
     * @param                            $leagueId
     *
     * @return array
     */
    public function update(UpdateLeagueDetailsRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueDetails = $this->dispatchFrom(UpdateLeagueDetailsCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueDetailsTransformer->transform($leagueDetails)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
