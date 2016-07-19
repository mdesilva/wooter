<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Organization\League\CreateLeaguePhotoCommand;
use Wooter\Commands\Organization\League\DeleteLeaguePhotoCommand;
use Wooter\Commands\Organization\League\ReadLeaguePhotoCommand;
use Wooter\Commands\Organization\League\ReadLeaguePhotosCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePublishPhotosCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeaguePhotoRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeaguePhotoRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeaguePhotoTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;


final class LeagueOrganizationPhotosController extends ApiController
{
    /**
     * @var LeaguePhotoTransformer
     */
    private $leaguePhotoTransformer;

    /**
     * @param LeaguePhotoTransformer $leaguePhotoTransformer
     */
    public function __construct(LeaguePhotoTransformer $leaguePhotoTransformer) {
        $this->leaguePhotoTransformer = $leaguePhotoTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/photos Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Photos
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Returns all photos for a league
     *
     * @apiSuccess {Collection} array Collection with all the photos.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       [
     *              'id' => 6,
     *              'league_id' => 2,
     *              'source' => 'football_match_beach.jpg',
     *              'name' => 'Football match in the beach',
     *       ],
     *       [
     *              'id' => 8,
     *              'league_id' => 2,
     *              'source' => 'football_match_court.jpg',
     *              'name' => 'Football match in the court',
     *       ],
     *     }
     *
     * @param $leagueId
     *
     * @apiUse LeagueNotFound
     * @apiUse LeaguePhotoNotFound
     * @apiUse NotPermissionException
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($leagueId)
    {
        try
        {
            $offset = Request::get('offset', self::DEFAULT_OFFSET);
            $limit = Request::get('limit', self::DEFAULT_LIMIT);
            $orderBy = Request::get('order_by', self::DEFAULT_ORDER_BY);
            $orderDirection = Request::get('order_direction', self::DEFAULT_ORDER_DIRECTION);

            $leaguePhotos = $this->dispatchFromArray(ReadLeaguePhotosCommand::class, ['league_id' => $leagueId, 'offset' => $offset, 'limit' => $limit, 'orderBy' => $orderBy, 'orderDirection' => $orderDirection]);

            return $this->respond([
                'data' => [
                    'photos' => $this->leaguePhotoTransformer->transformCollection($leaguePhotos['photos']),
                    'pages' => $leaguePhotos['pages']
                ]
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePhotoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/photos Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Photo
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new Photo for a league
     *
     * @apiParam {Number} league_id League id
     * @apiParam {File} image Image The photo to attach to the league
     * @apiParam {String} description Description of the photo
     *
     * @apiSuccess        Object LeaguePhoto
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'image' => 'football_match_beach.jpg',
     *              'description' => 'Football match in the beach',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeaguePhotoRequest $request
     *
     * @param                          $leagueId
     *
     * @return array
     */
    public function store(CreateLeaguePhotoRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leaguePhoto = $this->dispatchFrom(CreateLeaguePhotoCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            if(!$request->leaguePublishPhotoFlag) {
                return $this->respond([
                    'data' => $this->leaguePhotoTransformer->transform($leaguePhoto)
                ]);
            }
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/photos/:photoId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Photo
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates a new Photo for a league
     *
     * @apiParam {Number} league_id League id
     * @apiParam {Number} photo_id Image The photo to attach to the league
     *
     * @apiSuccess        Object LeaguePhoto
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'image' => 'football_match_beach.jpg',
     *              'description' => 'Football match in the beach',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param UpdateLeaguePhotoRequest $request
     *
     * @param                          $leagueId
     * @param                          $photoId
     *
     * @return array
     */
    public function update(UpdateLeaguePhotoRequest $request, $leagueId, $photoId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leaguePhoto = $this->dispatchFrom(UpdateLeaguePublishPhotosCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId, 'photo_id' => $photoId]);

            return $this->respond([
                'data' => $this->leaguePhotoTransformer->transform($leaguePhoto)
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
     * @api               {get} api/leagues/:leagueId/photos/:leaguePhotoId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Photo
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a league photo
     *
     * @apiParam {Number} LeagueId Id of the League
     * @apiParam {Number} leaguePhotoId Id of the League Photo
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 6,
     *              'league_id' => 6,
     *              'image' => 'football_match_beach.jpg',
     *              'description' => 'Football match in the beach',
     *          ]
     *     }
     *
     *
     * @apiUse            LeaguePhotoNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leaguePhotoId
     *
     * @return array
     */
    public function show($leagueId, $leaguePhotoId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $photo = $this->dispatchFromArray(ReadLeaguePhotoCommand::class, ['league_photo_id' => $leaguePhotoId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->leaguePhotoTransformer->transform($photo)
            ]);

        } catch (LeaguePhotoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/photos/:leaguePhotoId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Photo
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league photo
     *
     * @apiParam {Number} leagueId Id of the league
     * @apiParam {Number} leaguePhotoId Id of the league photo to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            LeaguePhotoNotFound
     * @apiUse            LeagueNotBelongToUser
     * @apiUse            DatabaseException
     *
     *
     * @param $leagueId
     * @param $photoId
     *
     * @return array
     * @internal          param $leaguePhotoId
     *
     */
    public function destroy($leagueId, $photoId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeaguePhotoCommand::class,['league_id' => $leagueId, 'photo_id' => $photoId, 'user_id' => $user->id]);
            
            return $this->respond([
                'data' => 'Success'
            ]);
        } catch (LeaguePhotoNotFound $e) {
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
