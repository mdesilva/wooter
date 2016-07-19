<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Wooter\Commands\Organization\League\CreateLeagueSeasonCommand;
use Wooter\Commands\Organization\League\DeleteLeagueSeasonCommand;
use Wooter\Commands\Organization\League\UpdateLeagueSeasonCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Organization\League\CreateLeagueSeasonRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueSeasonRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Competition\Season\SeasonCompetitionNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Commands\Organization\League\ReadLeagueSeasonsCommand;
use Wooter\Commands\Organization\League\ReadLeagueSeasonCommand;
use Exception;
use Wooter\Wooter\Transformers\Organization\League\LeagueSeasonsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;

final class LeagueOrganizationSeasonsController extends ApiController
{
    /**
     * @var LeagueSeasonsTransformer
     */
    private $leagueSeasonsTransformer;

    /**
     * @param LeagueSeasonsTransformer $leagueSeasonsTransformer
     *
     * @internal param LeagueSeasonsTransformer $leagueSeasonTransformer
     */
    public function __construct(LeagueSeasonsTransformer $leagueSeasonsTransformer) {

        $this->leagueSeasonsTransformer = $leagueSeasonsTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/seasons/ Index
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Season
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a league season
     *
     * @apiParam {Number} LeagueId Id of the League
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 2,
     *                  'league_id' => 6,
     *                  'name' => 'Summer Season',
     *                  'stars_at' => '15/10/2016',
     *                  'ends_at' => '15/12/2016',
     *                  'registration_opens_at' => '15/6/2016',
     *                  'registration_closes_at' => '15/10/2016',
     *                  'max_teams' => '10',
     *                  'max_free_agents' => '5'
     *                 },
     *               {
     *                  'id' => 2,
     *                  'league_id' => 6,
     *                  'name' => 'Summer Season',
     *                  'stars_at' => '15/10/2016',
     *                  'ends_at' => '15/12/2016',
     *                  'registration_opens_at' => '15/6/2016',
     *                  'registration_closes_at' => '15/10/2016',
     *                  'max_teams' => '10',
     *                  'max_free_agents' => '5'
     *                 }
     *          ]
     *     }
     *
     *
     * @param $leagueId
     *
     * @return array
     */
    public function index($leagueId) {
        try {
            $seasons = $this->dispatchFrom(ReadLeagueSeasonsCommand::class, new RequestObject(Request::all()), ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueSeasonsTransformer->transformCollection($seasons)
            ]);

        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }


    /**
     * @api               {post} api/leagues/:leagueId/seasons Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Season
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new season for a league
     *
     * @apiParam {Number} league_id League id of the league to create the season
     * @apiParam {String} name Name of the price.
     * @apiParam {String} starts_at The date when the season starts
     * @apiParam {String} ends_at The date when the season ends
     * @apiParam {String} registration_opens_at The date when the season registration opens
     * @apiParam {String} registration_closes_at The date when the season registration closes
     * @apiParam {Number} max_teams The maximum number of teams allowed in the season
     * @apiParam {Number} max_free_agents The maximum number of free agents allowed in the season
     *
     * @apiSuccess        Object LeagueSeason
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '2',
     *              'league_id' => '6',
     *              'name' => 'Summer Season',
     *              'stars_at' => '15/10/2016',
     *              'ends_at' => '15/12/2016',
     *              'registration_opens_at' => '15/6/2016',
     *              'registration_closes_at' => '15/10/2016',
     *              'max_teams' => '10',
     *              'max_free_agents' => '5',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeagueSeasonRequest $request
     *
     * @param                           $leagueId
     *
     * @return array
     */
    public function store(CreateLeagueSeasonRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueSeason = $this->dispatchFrom(CreateLeagueSeasonCommand::class, $request, ['user_id' =>  $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueSeasonsTransformer->transform($leagueSeason)
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
     * @api               {get} api/leagues/:leagueId/seasons/:leagueSeasonId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Season
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a league season
     *
     * @apiParam {Number} LeagueId Id of the League
     * @apiParam {Number} id Id of the League Season
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '2',
     *              'league_id' => '6',
     *              'name' => 'Summer Season',
     *              'stars_at' => '15/10/2016',
     *              'ends_at' => '15/12/2016',
     *              'registration_opens_at' => '15/6/2016',
     *              'registration_closes_at' => '15/10/2016',
     *              'max_teams' => '10',
     *              'max_free_agents' => '5',
     *          ]
     *     }
     *
     *
     * @apiUse            SeasonCompetitionNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leagueId
     * @param $seasonId
     *
     * @return array
     * @internal          param $leagueSeasonId
     *
     */
    public function show($leagueId, $seasonId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $season = $this->dispatchFromArray(ReadLeagueSeasonCommand::class, ['league_id' => $leagueId, 'user_id' => $user->id, 'season_id' => $seasonId]);

            return $this->respond([
                'data' => $this->leagueSeasonsTransformer->transform($season)
            ]);

        } catch (SeasonCompetitionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/seasons/:seasonId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Season
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league season
     *
     * @apiParam {Number} leagueId Id of the league
     * @apiParam {Number} seasonId Id of the season
     * @apiParam {String} name Name of the season
     * @apiParam {String} starts_at Starting date of the season
     * @apiParam {String} ends_at Ending date of the season
     * @apiParam {String} registration_opens_at Registeration opening date of the season
     * @apiParam {String} registration_closes_at Registeration closing date of the season
     * @apiParam {Number} max_teams Maximum team of the season
     * @apiParam {Number} max_free_agents Maximum agents of the season
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '2',
     *              'league_id' => '6',
     *              'name' => 'Summer Season',
     *              'stars_at' => '15/10/2016',
     *              'ends_at' => '15/12/2016',
     *              'registration_opens_at' => '15/6/2016',
     *              'registration_closes_at' => '15/10/2016',
     *              'max_teams' => '10',
     *              'max_free_agents' => '5',
     *          ]
     *     }
     *
     * @apiUse            SeasonCompetitionNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param UpdateLeagueSeasonRequest $request
     * @param                           $leagueId
     * @param                           $seasonId
     *
     * @return array
     *
     */
    public function update(UpdateLeagueSeasonRequest $request, $leagueId, $seasonId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $leagueSeason = $this->dispatchFrom(UpdateLeagueSeasonCommand::class, $request, ['league_id' => $leagueId, 'user_id' =>  $user_id, 'season_id' => $seasonId]);

            return $this->respond([
                'data' => $this->leagueSeasonsTransformer->transform($leagueSeason)
            ]);

        } catch (SeasonCompetitionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/seasons/:leagueSeasonId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Season
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league season
     *
     * @apiParam {Number} league_id Id of the league
     * @apiParam {Number} leagueSeasonId Id of the league season to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            SeasonCompetitionNotFound
     * @apiUse            LeagueNotBelongToUser
     * @apiUse            DatabaseException
     *
     *
     * @param $league_id
     * @param $seasonId
     *
     * @return array
     * @internal          param $leagueSeasonId
     *
     */
    public function destroy($league_id, $seasonId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueSeasonCommand::class,['league_id' => $league_id, 'user_id' =>  $user->id, 'season_id' => $seasonId]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (SeasonCompetitionNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
