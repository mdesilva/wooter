<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Organization\League\CreateLeagueGameVenueCommand;
use Wooter\Commands\Organization\League\DeleteLeagueGameVenueCommand;
use Wooter\Commands\Organization\League\ReadLeagueGameVenueCommand;
use Wooter\Commands\Organization\League\ReadLeagueGameVenuesCommand;
use Wooter\Commands\Organization\League\UpdateLeagueGameVenueCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeagueGameVenueRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueGameVenueRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Transformers\Organization\League\LeagueGameVenueTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;


final class LeagueOrganizationGameVenuesController extends ApiController
{
    /**
     * @var LeagueGameVenueTransformer
     */
    private $leagueGameVenueTransformer;
    /**
     * @param LeagueGameVenueTransformer $leagueGameVenueTransformer
     */
    public function __construct(LeagueGameVenueTransformer $leagueGameVenueTransformer) {
        $this->leagueGameVenueTransformer = $leagueGameVenueTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/game-venues Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Game Venue
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Returns all games venues for a league
     *
     * @apiSuccess {Collection} array Collection with all the game venues of the league
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       [
     *              'address' => '5 Avenue 14',
     *              'country' => 'United States',
     *              'city' => 'New York City',
     *              'state' => 'New York',
     *              'x' => '42.5342',
     *              'y' => '112.3235',
     *       ],
     *       [
     *              'address' => '5 Avenue 14',
     *              'country' => 'United States',
     *              'city' => 'New York City',
     *              'state' => 'New York',
     *              'x' => '42.5342',
     *              'y' => '112.3235',
     *       ],
     *     }
     *
     * @apiUse GameVenueNotFound
     * @apiUse LeagueNotFound
     * @apiUse NotPermissionException
     *
     * @param $leagueId
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($leagueId)
    {
        try
        {
            $limit = Request::get('limit');

            $leagueGameVenues = $this->dispatchFromArray(ReadLeagueGameVenuesCommand::class, ['league_id' => $leagueId, 'limit'=>$limit]);

            return $this->respond([
                'data' => $this->leagueGameVenueTransformer->transformCollection($leagueGameVenues)
            ]);
        } catch (GameVenueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (LeagueNotFound $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/game-venues Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Game Venue
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new League Game Venue for the League
     *
     * @apiParam {Number} league_id League id of the league to save the game venue
     * @apiParam {String} full_address Address of the venue
     * @apiParam {Number} country_id Country where the venue is
     * @apiParam {Number} city_name City where the venue is
     * @apiParam {String} state State where the venue is
     * @apiParam {String} flat Flat where the venue is
     * @apiParam {Number} x Coordinate x where the venue is
     * @apiParam {Number} y Coordinate y where the venue is
     *
     * @apiSuccess        Object LeagueOrganizationDetails
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'location_id' => 6,
     *              'full_address' => '5 Avenue 14',
     *              'country' => 'United States',
     *              'country_id' => 4,
     *              'city' => 'New York City',
     *              'city_id' => 10,
     *              'state' => 'New York',
     *              'latitude' => '42.5342',
     *              'longitude' => '112.3235',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeagueGameVenueRequest $request
     *
     * @param                              $leagueId
     *
     * @return array
     */
    public function store(CreateLeagueGameVenueRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueGameVenue = $this->dispatchFrom(CreateLeagueGameVenueCommand::class, $request, ['league_id' => $leagueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leagueGameVenueTransformer->transform($leagueGameVenue)
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
     * @api               {get} api/leagues/:leagueId/game-venues/:gameVenueId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Game Venue
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a the league game venue
     * @apiParam {Number} LeagueId Id of the League
     * @apiParam {Number} gameVenueId Id of the Game Venue
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'full_address' => '5 Avenue 14',
     *              'country' => 'United States',
     *              'country_id' => 4,
     *              'city' => 'New York City',
     *              'city_id' => 10,
     *              'state' => 'New York',
     *              'latitude' => '42.5342',
     *              'longitude' => '112.3235',
     *          ]
     *     }
     *
     * @apiUse            GameVenueNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leagueId
     * @param $gameVenueId
     *
     * @return array
     */
    public function show($leagueId, $gameVenueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueGameVenue = $this->dispatchFromArray(ReadLeagueGameVenueCommand::class, ['league_id' => $leagueId, 'game_venue_id' => $gameVenueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leagueGameVenueTransformer->transform($leagueGameVenue)
            ]);
        } catch (GameVenueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/game-venues/:gameVenueId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Game Venue
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league game venue
     *
     * @apiParam {Number} leagueId League id of the league to update the game venue
     * @apiParam {Number} gameVenueId Id of the Game Venue
     * @apiParam {String} address Address of the venue
     * @apiParam {Number} country_id Country where the venue is
     * @apiParam {String} city City where the venue is
     * @apiParam {String} state State where the venue is
     * @apiParam {Number} x Coordinate x where the venue is
     * @apiParam {Number} y Coordinate y where the venue is
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'location_id' => 6,
     *              'full_address' => '5 Avenue 14',
     *              'country' => 'United States',
     *              'country_id' => 4,
     *              'city' => 'New York City',
     *              'city_id' => 10,
     *              'state' => 'New York',
     *              'latitude' => '42.5342',
     *              'longitude' => '112.3235',
     *          ]
     *     }
     *
     * @apiUse            GameVenueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param UpdateLeagueGameVenueRequest $request
     * @param                 $leagueId
     * @param Number          $gameVenueId
     *
     * @return array
     */
    public function update(UpdateLeagueGameVenueRequest $request, $leagueId, $gameVenueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueGameVenue = $this->dispatchFrom(UpdateLeagueGameVenueCommand::class, $request, ['league_id' => $leagueId, 'game_venue_id' => $gameVenueId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leagueGameVenueTransformer->transform($leagueGameVenue)
            ]);
        } catch (GameVenueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {
            dd($e->getLine(), $e->getFile(), $e->getTrace());
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/game-venues/:gameVenueId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Game Venue
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league game venue
     *
     * @apiParam {Number} LeagueId Id of the League
     * @apiParam {Number} gameVenueId Id of the Game Venue
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            GameVenueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param $leagueId
     * @param $gameVenueId
     *
     * @return array
     */
    public function destroy($leagueId, $gameVenueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueGameVenueCommand::class,['user_id' => $user->id, 'league_id' => $leagueId, 'game_venue_id' => $gameVenueId]);

            return $this->respond([
                'data' => 'Success'
            ]);
        } catch (GameVenueNotFound $e) {
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
