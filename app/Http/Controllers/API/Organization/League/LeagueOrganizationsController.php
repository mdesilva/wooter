<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;
use Wooter\Commands\Organization\League\CheckUserIsLeagueOwnerCommand;
use Wooter\Http\Requests\Organization\League\CreateLeagueOrganizationRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\League\CreateLeagueCommand;
use Wooter\Commands\Organization\League\ReadLeagueCommand;
use Wooter\Commands\Organization\League\SearchLeaguesCommand;
use Wooter\Commands\Organization\League\UpdateLeagueCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\UpdateLeagueRequest;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserHasNoLeagues;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeagueTransformer;

final class LeagueOrganizationsController extends ApiController
{
    /**
     * @var LeagueTransformer
     */
    private $LeagueTransformer;

    public function __construct(LeagueTransformer $LeagueTransformer) {
        $this->LeagueTransformer = $LeagueTransformer;
        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
            'toggleDreamLeague',
        ]]);
    }

    /**
     * @api               {get} api/leagues Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League
     * @apiDescription    Returns an array of all the leagues that matches the filter parameters
     *
     * @apiSuccess {Array} data Array with all the leagues.
     *
     * @apiParam {string} [name] Name of the league
     * @apiParam {integer} [min_age] Minimum age of the league
     * @apiParam {integer} [max_age] Maximum age of the league
     * @apiParam {integer} [zip] Zip code of the location
     * @apiParam {decimal} [longitude] Longitude where the league is located
     * @apiParam {decimal} [latitude] Latitude where the league is located
     * @apiParam {integer} [sport_id] ID of the sport to search for
     * @apiParam {integer} [limit] Limit of results
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => 1,
     *                  'archived' => 0,
     *                  'organization_id' => 1,
     *                  'sport_id' => 1,
     *                  'organization_name' => 'LFP',
     *                  'organization_email' => 'support@lfp.es',
     *                  'name' => 'LFP',
     *                  'dream_league' => 1,
     *                  'basics' => $league_basics,
     *                  'details' => $league_details,
     *                  'locations' => $league_locations,
     *                  'seasons' => $league_seasons,
     *                  'divisions' => $league_divisions,
     *                  'photos' => $league_photos,
     *                  'videos' => $league_videos,
     *                  'qnapVideos' => $league_qnapVideos,
     *                  'game_venues' => $league_game_venues,
     *                  'sport' => $sport,
     *              ]
     *          ]
     *     }
     *
     * @apiUse UserHasNoOrganization
     * @apiUse UserHasNoLeagues
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $leagues = $this->dispatchFrom(SearchLeaguesCommand::class, new RequestObject(Request::all()), ['user_id' => $user->id]);

            return $this->respond(
                ['data' => $this->LeagueTransformer->transformCollection($leagues)]
            );

        } catch (UserHasNoOrganization $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoLeagues $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues Create
     * @apiVersion        1.0.0
     * @apiName           Create a new league
     * @apiGroup          League
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Creates a new league
     *
     * @apiParam {String} name Name of the organization
     * @apiParam {String} phone Phone of the organization
     * @apiParam {Integer} sport_id ID of the sport of the league
     * @apiParam {String} [url] URL
     * @apiParam {boolean} [dream_league] Whether the league is dream_league (Belongs to DreamLeagues)
     * @apiParam {String} [instagram] Instagram of the organization
     * @apiParam {String} [facebook] Facebook of the organization
     * @apiParam {String} [pinterest] Pinterest of the organization
     * @apiParam {String} [google] Google of the organization
     * @apiParam {String} [twitter] Twitter of the organization
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'archived' => 0,
     *                  'organization_id' => 1,
     *                  'sport_id' => 1,
     *                  'organization_name' => 'LFP',
     *                  'organization_email' => 'support@lfp.es',
     *                  'name' => 'LFP',
     *                  'dream_league' => 1,
     *                  'basics' => $league_basics,
     *                  'details' => $league_details,
     *                  'locations' => $league_locations,
     *                  'seasons' => $league_seasons,
     *                  'divisions' => $league_divisions,
     *                  'photos' => $league_photos,
     *                  'videos' => $league_videos,
     *                  'qnapVideos' => $league_qnapVideos,
     *                  'game_venues' => $league_game_venues,
     *                  'sport' => $sport,
     *              ]
     *     }
     *
     * @apiUse            UserNotFound
     * @apiUse            UserHasNoOrganization
     *
     *
     * @param CreateLeagueOrganizationRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueOrganizationRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $league = $this->dispatchFrom(CreateLeagueCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->LeagueTransformer->transform($league)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    public function isOwner($leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(CheckUserIsLeagueOwnerCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    public function activate($leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(CheckUserIsLeagueOwnerCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserHasNoOrganization $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId Read
     *  @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League
     * @apiDescription    Gets a league
     *
     * @apiParam {Integer} leagueId Id of the league
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'archived' => 0,
     *                  'organization_id' => 1,
     *                  'sport_id' => 1,
     *                  'organization_name' => 'LFP',
     *                  'organization_email' => 'support@lfp.es',
     *                  'name' => 'LFP',
     *                  'dream_league' => 1,
     *                  'basics' => $league_basics,
     *                  'details' => $league_details,
     *                  'locations' => $league_locations,
     *                  'seasons' => $league_seasons,
     *                  'divisions' => $league_divisions,
     *                  'photos' => $league_photos,
     *                  'videos' => $league_videos,
     *                  'qnapVideos' => $league_qnapVideos,
     *                  'game_venues' => $league_game_venues,
     *                  'sport' => $sport,
     *              ]
     *     }
     *
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return array
     */
    public function show($leagueId)
    {
        try
        {
            $league = $this->dispatchFromArray(ReadLeagueCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueTransformer->transform($league)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId Update
     *  @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Updates the league
     *
     * @apiParam {Number} leagueId ID of the league to update
     * @apiParam {String} name Name of the league
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'archived' => 0,
     *                  'organization_id' => 1,
     *                  'sport_id' => 1,
     *                  'organization_name' => 'LFP',
     *                  'organization_email' => 'support@lfp.es',
     *                  'name' => 'LFP',
     *                  'dream_league' => 1,
     *                  'basics' => $league_basics,
     *                  'details' => $league_details,
     *                  'locations' => $league_locations,
     *                  'seasons' => $league_seasons,
     *                  'divisions' => $league_divisions,
     *                  'photos' => $league_photos,
     *                  'videos' => $league_videos,
     *                  'qnapVideos' => $league_qnapVideos,
     *                  'game_venues' => $league_game_venues,
     *                  'sport' => $sport,
     *              ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param UpdateLeagueRequest $request
     * @param Number              $leagueId
     *
     * @return array
     */
    public function update(UpdateLeagueRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $league = $this->dispatchFrom(UpdateLeagueCommand::class, $request, ['league_id' => $leagueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->LeagueTransformer->transform($league)
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
     *
     * @deprecated DO NOT USE
     *
     * @api               {delete} api/leagues/:leagueId Delete
     *  @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Deletes a league
     *
     * @apiParam {Number} leagueId ID of the league to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse             LeagueNotFound
     * @apiUse             LeagueNotBelongToUser
     * @apiUse             DatabaseException
     *
     * @param $leagueId
     *
     * @return array

    public function destroy($leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueCommand::class,['league_id' => $leagueId, 'user_id' => $user->id]);
            
            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
     */
}
