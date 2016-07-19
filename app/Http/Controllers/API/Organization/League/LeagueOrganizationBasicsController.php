<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\League\DeleteLeagueBasicsCommand;
use Wooter\Commands\Organization\League\ReadLeagueBasicsCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Organization\League\CreateLeagueBasicsRequest;
use Wooter\Commands\Organization\League\CreateLeagueBasicsCommand;
use Wooter\Commands\Organization\League\UpdateLeagueBasicsCommand;
use Wooter\Http\Requests\Organization\League\UpdateLeagueBasicsRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueBasicsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeagueBasicsTransformer;

final class LeagueOrganizationBasicsController extends ApiController
{

    /**
     * @var LeagueBasicsTransformer
     */
    private $LeagueBasicsTransformer;

    /**
     * @param LeagueBasicsTransformer $LeagueBasicsTransformer
     */
    public function __construct(LeagueBasicsTransformer $LeagueBasicsTransformer) {
        $this->LeagueBasicsTransformer = $LeagueBasicsTransformer;

         $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {post} api/league/:leagueId/league_basics Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Basics
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new League Basics for the League
     *
     * @apiParam {Number} leagueId League id of the league to save the basics to
     * @apiParam {Number} sport_id Sport id. From the Sports list.
     * @apiParam {Number} min_age Minimum age allowed in the league
     * @apiParam {Number} max_age Maximum age allowed in the league
     * @apiParam {String} gender Gender of the league
     * @apiParam {String} logo Logo of the league
     *
     * @apiSuccess        Object LeagueOrganizationBasics
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'league_id' => '6',
     *              'sport_id' => '4',
     *              'min_age' => '14',
     *              'max_age' => '18',
     *              'gender' => 'female',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param CreateLeagueBasicsRequest $request
     *
     * @param                           $leagueId
     *
     * @return array
     */
    public function store(CreateLeagueBasicsRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueBasics = $this->dispatchFrom(CreateLeagueBasicsCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueBasicsTransformer->transform($leagueBasics)
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
     * @api               {get} api/league/:leagueId/league_basics Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Basics
     * @apiDescription    Returns the basic information for the requested league
     * @apiParam {Number} leagueId Id of the League
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'league_id' => '6',
     *              'sport_id' => '4',
     *              'min_age' => '14',
     *              'max_age' => '18',
     *              'gender' => 'female',
     *              'sport' => [
     *                    'name' => 'Football',
     *                    'id' => '2',
     *              ],
     *              'logo' => [
     *                    'mime_type' => 'image/jpg',
     *                    'extension' => 'jpg',
     *                    'size' => '24353',
     *                    'file_path' => '/public/image.jpg',
     *                    'thumbnail_path' => '/public/image-thumb.jpg',
     *                    'file_name' => 'Real Madrid Official Photo',
     *              ],
     *          ]
     *     }
     *
     * @param $leagueId
     *
     * @return array
     */
    public function index($leagueId)
    {
        try
        {
            $leagueBasics = $this->dispatchFromArray(ReadLeagueBasicsCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueBasicsTransformer->transform($leagueBasics)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/league/:leagueId/league_basics Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Basics
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league basics
     *
     * @apiParam {Number} leagueId Id of the League to update
     * @apiParam {Number} sport_id Sport id. From the Sports list.
     * @apiParam {Number} min_age Minimum age allowed in the league
     * @apiParam {Number} max_age Maximum age allowed in the league
     * @apiParam {String} gender Gender of the league
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'league_id' => '6',
     *              'sport_id' => '4',
     *              'min_age' => '14',
     *              'max_age' => '18',
     *              'gender' => 'female',
     *          ]
     *     }
     *
     * @apiUse LeagueBasicsNotFound
     * @apiUse LeagueNotBelongToUser
     *
     * @param UpdateLeagueBasicsRequest $request
     * @param                           $leagueId
     *
     * @return array
     *
     */
    public function update(UpdateLeagueBasicsRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $leagueBasics = $this->dispatchFrom(UpdateLeagueBasicsCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueBasicsTransformer->transform($leagueBasics)
            ]);

        } catch (LeagueBasicsNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
