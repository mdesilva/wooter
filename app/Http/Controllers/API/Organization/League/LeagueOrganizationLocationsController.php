<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Commands\Organization\League\CreateLeagueLocationCommand;
use Wooter\Commands\Organization\League\DeleteLeagueLocationCommand;
use Wooter\Commands\Organization\League\ReadLeagueLocationCommand;
use Wooter\Commands\Organization\League\UpdateLeagueLocationCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeagueLocationRequest;
use Wooter\Http\Requests\LocationRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueLocationNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Wooter\Transformers\Organization\League\LeagueLocationTransformer;


final class LeagueOrganizationLocationsController extends ApiController
{
    /**
     * @param LeagueLocationTransformer $leagueLocationTransformer
     */
    public function __construct(LeagueLocationTransformer $leagueLocationTransformer) {
        $this->leagueLocationTransformer = $leagueLocationTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/locations Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, admin
     * @apiGroup          League Location
     * @apiDescription    Returns the League Game Venue for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     *
     * @apiSuccess Object LeagueOrganizationLocation
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'league_location_id' => 1,
     *                  'league_id' => 1,
     *                  'location_id' => 1,
     *                  'country' => 'Micheal Wilkinson',
     *                  'city' => 'North Catherine',
     *                  'state' => 'NY',
     *                  'longitude' => '136.271624',
     *                  'latitude' => '51.191592',
     *                  'name' => 'Miss Bonnie Champlin',
     *                  'street' => '42.5342',
     *                  'zip' => '56273',
     *                  'full_address' => '906 Horace Rest Suite 067 Schillershire, MO 09302',
     *                  'flat' => '128',
     *                  'distance' => '112.3235'
     *              },
     *              {
     *                  'league_location_id' => 2,
     *                  'league_id' => 2,
     *                  'location_id' => 1,
     *                  'country' => 'Micheal Wilkinson',
     *                  'city' => 'North Catherine',
     *                  'state' => 'NY',
     *                  'longitude' => '136.271624',
     *                  'latitude' => '51.191592',
     *                  'name' => 'Miss Bonnie Champlin',
     *                  'street' => '42.5342',
     *                  'zip' => '56273',
     *                  'full_address' => '906 Horace Rest Suite 067 Schillershire, MO 09302',
     *                  'flat' => '128',
     *                  'distance' => '112.3235'
     *              }
     *          ]
     *     }
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId) {
        try
        {
            $locations = $this->dispatchFromArray(ReadLeagueLocationCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueLocationTransformer->transformCollection($locations)
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
            return $this->respondInternalError($e->getMessage());
        }
    }
   
    /**
     * @api               {post} api/leagues/:leagueId/locations Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Location
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new League Game Venue for the League
     *
     * @apiParam {Number} league_id League id of the league to save the location
     * @apiParam {String} full_address Address of the venue
     * @apiParam {Number} country_id Country where the venue is
     * @apiParam {Number} city_id City where the venue is
     * @apiParam {String} state State where the venue is
     * @apiParam {String} flat Flat where the venue is
     * @apiParam {Number} x Coordinate x where the venue is
     * @apiParam {Number} y Coordinate y where the venue is
     *
     * @apiSuccess        Object LeagueOrganizationLocation
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
     * @param CreateLeagueLocationRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueLocationRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueLocation = $this->dispatchFrom(CreateLeagueLocationCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leagueLocationTransformer->transform($leagueLocation)
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
     * @api               {get} api/leagues/:leagueId/locations/:leagueLocationId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Location
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a the league location
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Number} leagueLocationId Location Id of the League
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
     * @apiUse            LeagueLocationNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leagueLocationId
     *
     * @return JsonResponse
     */
    public function show($leagueLocationId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $leagueLocation = $this->dispatchFromArray(ReadLeagueLocationCommand::class, ['league_location_id' => $leagueLocationId, 'user_id' => $user_id]);

            return $this->respond([
                'data' => $this->leagueLocationTransformer->transform($leagueLocation)
            ]);
        } catch (LeagueLocationNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/locations/:leagueLocationId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Location
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league location
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Number} leagueLocationId Location id of the league to save the location
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
     * @apiUse            LeagueLocationNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param Requests\LocationRequest $request
     * @param Number                   $leagueLocationId
     *
     * @return JsonResponse
     */
    public function update(LocationRequest $request, $leagueLocationId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $leagueLocation = $this->dispatchFrom(UpdateLeagueLocationCommand::class, $request, ['league_location_id' => $leagueLocationId, 'user_id' => $user_id]);
            return $this->respond([
                'data' => $this->leagueLocationTransformer->transform($leagueLocation)
            ]);
        } catch (LeagueLocationNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
    /**
     * @api               {delete} api/leagues/:leagueId/locations/:leagueLocationId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Location
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league location
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Number} leagueLocationId Id of the league location to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            LeagueLocationNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param $leagueLocationId
     *
     * @return JsonResponse
     */
    public function destroy($leagueLocationId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $this->dispatchFromArray(DeleteLeagueLocationCommand::class,['league_location_id' => $leagueLocationId, 'user_id' => $user_id]);
            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (LeagueLocationNotFound $e) {
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
