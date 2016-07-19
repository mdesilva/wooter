<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Organization\League\CreateLeagueVideoCommand;
use Wooter\Commands\Organization\League\DeleteLeagueVideoCommand;
use Wooter\Commands\Organization\League\ReadLeagueVideoCommand;
use Wooter\Commands\Organization\League\ReadLeagueVideosCommand;
use Wooter\Commands\Organization\League\UpdateLeagueVideoCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Organization\League\CreateLeagueVideoRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueVideoRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeaguePublishVideosRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Transformers\Organization\League\LeagueVideoTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;


final class LeagueOrganizationVideosController extends ApiController
{
    /**
     * @var LeagueVideoTransformer
     */
    private $leagueVideoTransformer;

    /**
     * @param LeagueVideoTransformer $leagueVideoTransformer
     */
    public function __construct(LeagueVideoTransformer $leagueVideoTransformer) {
        $this->leagueVideoTransformer = $leagueVideoTransformer;
        $this->middleware('jwt.auth');
        $this->middleware('user.is_organization');
    }


    /**
     * @api               {get} api/leagues/:leagueId/videos Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Videos
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Returns all videos for a league
     *
     * @apiParam {Number} leagueId Id of the league 
     * @apiSuccess {Collection} array Collection with all the videos.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       [
     *                  'id' => 1,
     *                  'league_id' => 1,
     *                  'label_id' => 3,
     *                  'game_id' => 2,
     *                  'video_id' => 1,
     *                  'description' => 'Jodie Gleason',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *                  'size' => '81686',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'file_name' => 'Jodie Gleason',
     *                  'date' => 'Jodie Gleason',
     *                  'tagTeams' => 'Jodie Gleason',
     *                  'tagPlayers' => 'Jodie Gleason',
     *       ],
     *       [
     *                  'id' => 2,
     *                  'league_id' => 2,
     *                  'label_id' => 2,
     *                  'game_id' => 2,
     *                  'video_id' => 1,
     *                  'description' => 'Jodie Gleason',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *                  'size' => '81686',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'file_name' => 'Jodie Gleason',
     *                  'date' => 'Jodie Gleason',
     *                  'tagTeams' => 'Jodie Gleason',
     *                  'tagPlayers' => 'Jodie Gleason',*       ],
     *     }
     *
     * @apiUse LeagueNotFound
     * @apiUse LeagueVideoNotFound
     * @apiUse NotPermissionException
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId)
    {

        try
        {
            $offset = Request::get('offset', self::DEFAULT_OFFSET);
            $limit = Request::get('limit', self::DEFAULT_LIMIT);
            $orderBy = Request::get('order_by', self::DEFAULT_ORDER_BY);
            $orderDirection = Request::get('order_direction', self::DEFAULT_ORDER_DIRECTION);
            $orderByVideosType = Request::get('order_by_videos_type', self::DEFAULT_ORDER_BY_VIDEOS_TYPE);
            $getVideosType = Request::get('get_videos_type', self::DEFAULT_GET_VIDEOS_TYPE);

            $leagueVideos = $this->dispatchFromArray(ReadLeagueVideosCommand::class, ['league_id' => $leagueId, 'offset' => $offset, 'limit' => $limit, 'orderBy' => $orderBy, 'orderDirection' => $orderDirection, 'orderByVideosType' => $orderByVideosType, 'getVideosType' => $getVideosType]);


            return $this->respond([
                'data' => ['videos' => $this->leagueVideoTransformer->transformCollection($leagueVideos['videos']),
                    'pages' => $leagueVideos['pages']
                ]
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * @api               {post} api/leagues/:leagueId/videos Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Creates a new Video for a league
     *
     * @apiParam {Number} leagueId League id of the league to link the video
     * @apiParam {String} description Description for the video
     * @apiParam {File} video Video
     *
     * @apiSuccess        Object LeagueOrganizationVideo
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'league_id' => 1,
     *                  'label_id' => 3,
     *                  'game_id' => 2,
     *                  'video_id' => 1,
     *                  'description' => 'Jodie Gleason',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *                  'size' => '81686',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'file_name' => 'Jodie Gleason',
     *                  'date' => 'Jodie Gleason',
     *                  'tagTeams' => 'Jodie Gleason',
     *                  'tagPlayers' => 'Jodie Gleason',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeagueVideoRequest $request
     * @param                          $leagueId
     *
     * @return array
     */
    public function store(CreateLeagueVideoRequest $request, $leagueId)
    {
       try
        {

            $leagueVideo = $this->dispatchFrom(CreateLeagueVideoCommand::class, $request, ['user_id' => JWTAuth::parseToken()->authenticate()->id, 'league_id' => $leagueId]);

            if($request->leaguePublishVideoFlag)
            {
                return $this->respond([
                    'data' => 'Published Successfully'
                ]);
            }

            return $this->respond([
                'data' => $this->leagueVideoTransformer->transform($leagueVideo)
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
     * @api               {get} api/leagues/:leagueId/videos/:leagueVideoId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Gets a league video
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Number} leagueVideoId Id of the League Video to retrieve
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'league_id' => 1,
     *                  'label_id' => 3,
     *                  'game_id' => 2,
     *                  'video_id' => 1,
     *                  'description' => 'Jodie Gleason',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *                  'size' => '81686',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'file_name' => 'Jodie Gleason',
     *                  'date' => 'Jodie Gleason',
     *                  'tagTeams' => 'Jodie Gleason',
     *                  'tagPlayers' => 'Jodie Gleason',
     *          ]
     *     }
     *
     *
     * @apiUse            LeagueVideoNotFound
     * @apiUse            NotPermissionException
     *
     * @param $leagueVideoId
     *
     * @return array
     */
    public function show($leagueId, $leagueVideoId)
    {

        try
        {
            $leagueVideo = $this->dispatchFromArray(ReadLeagueVideoCommand::class, ['league_video_id' => $leagueVideoId, 'user_id' => JWTAuth::parseToken()->authenticate()->id]);

            return $this->respond([
                'data' => $this->leagueVideoTransformer->transform($leagueVideo)
            ]);

        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            var_dump($e->getLine(), $e->getMessage(), $e->getFile());die;
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/leagues/:leagueId/videos/:leagueVideoId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Updates the league video
     *
     * @apiParam {Number} leagueId League id of the league to link the video
     * @apiParam {Number} leagueVideoId League video id of the video
     * @apiParam {String} description Description for the video
     * @apiParam {File} video Video
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *                  'id' => 1,
     *                  'league_id' => 1,
     *                  'label_id' => 3,
     *                  'game_id' => 2,
     *                  'video_id' => 1,
     *                  'description' => 'Jodie Gleason',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *                  'size' => '81686',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'file_name' => 'Jodie Gleason',
     *                  'date' => 'Jodie Gleason',
     *                  'tagTeams' => 'Jodie Gleason',
     *                  'tagPlayers' => 'Jodie Gleason',
     *          ]
     *     }
     *
     * @apiUse            LeagueVideoNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param UpdateLeagueVideoRequest $request
     * @param                          $leagueVideoId
     *
     * @return array
     */
    public function update(UpdateLeagueVideoRequest $request, $leagueVideoId)
    {
        try
        {
            $leagueVideo = $this->dispatchFrom(UpdateLeagueVideoCommand::class, $request, ['league_video_id' => $leagueVideoId, 'user_id' => JWTAuth::parseToken()->authenticate()->id]);

            return $this->respond([
                'data' => $this->leagueVideoTransformer->transform($leagueVideo)
            ]);

        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/leagues/:leagueId/videos/:leagueVideoId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the league video
     *
     * @apiParam {Number} leagueId League id of the league to link the video
     * @apiParam {Number} leagueVideoId League video id of the video
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            LeagueVideoNotFound
     * @apiUse            LeagueNotBelongToUser
     * @apiUse            DatabaseException
     *
     *
     * @param $leagueVideoId
     *
     * @return array
     */
    public function destroy($leagueId, $leagueVideoId)
    {

        try
        {

            $this->dispatchFromArray(DeleteLeagueVideoCommand::class,['league_video_id' => $leagueVideoId, 'user_id' => JWTAuth::parseToken()->authenticate()->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/publishLeagueVideos publishVideos
     * @apiVersion        1.0.0
     * @apiName           publishVideos
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Publish the league video
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Array} videos Videos to be published
     * @apiParam {Number} players Players to be tagged
     * @apiParam {Number} teams Teams of the leagues attached 
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Published successfully'
     *     }
     *
     * @apiUse            LeagueVideoNotFound
     *
     *
     * @param UpdateLeaguePublishVideosRequest $request
     *
     * @return array
     */
   /* public function publishVideos(UpdateLeaguePublishVideosRequest $request)
    {
        try
        {
            $this->dispatchFrom(UpdateLeaguePublishVideosCommand::class, $request, ['user_id' => JWTAuth::parseToken()->authenticate()->id]);

            return $this->respond([
                'data' => 'Published Successfully'
            ]);
        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

    }*/

    /**
     * @api               {delete} api/leagues/:leagueId/deletePublishedLeagueVideos deletePublishedVideos
     * @apiVersion        1.0.0
     * @apiName           deletePublishedVideos
     * @apiGroup          League Video
     * @apiPermission     organization, organization staff, admin
     * @apiDescription    Deletes the Published league video
     *
     * @apiParam {Number} leagueId Id of the League
     * @apiParam {Array} videos Videos to be published
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            LeagueVideoNotFound
     *
     *
     * @param UpdateLeaguePublishVideosRequest $request
     *
     * @return array
     */
   /* public function deletePublishedVideos(UpdateLeaguePublishVideosRequest $request)
    {
        try
        {
            $this->dispatchFrom(DeleteLeaguePublishedVideoCommand::class, $request, ['user_id' => JWTAuth::parseToken()->authenticate()->id]);

            return $this->respond([
                'data' => 'Deleted Successfully'
            ]);
        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

    }*/

}
