<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Http\Requests\Organization\League\CreateLeaguePhotoAlbumRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeaguePhotoAlbumRequest;
use Wooter\Commands\Organization\League\CreateLeaguePhotoAlbumsCommand;
use Wooter\Commands\Organization\League\ReadLeaguePhotoAlbumsCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePhotoAlbumsCommand;
use Wooter\Commands\Organization\League\DeleteLeaguePhotoAlbumsCommand;
use Wooter\Wooter\Transformers\Organization\League\LeaguePhotoAlbumsTransformer;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\DatabaseException;

class LeagueOrganizationPhotoAlbumsController extends ApiController
{


    private $leaguePhotoAlbumTransformer;

    public function __construct(LeaguePhotoAlbumsTransformer $leaguePhotoAlbumsTransformer)
    {
        $this->leaguePhotoAlbumTransformer = $leaguePhotoAlbumsTransformer;

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
     * @api               {get} api/leagues/:leagueId/photoAlbum Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Photo Albums
     * @apiPermission     organization, JWT
     * @apiDescription    Returns the photo albums of the requested league
     *
     * @apiParam {Number} league_id League id of the league.
     *
     * @apiSuccess Object LeagueOrganizationPhotoAlbums
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'name' => 'Finals',
     *              },
     *              {
     *                  'id' => 2,
     *                  'name' => 'Semi-Finals',
     *              }
     *          ]
     *     }
     *
     * @apiUse LeagueNotFound
     *
     * @param $league_id
     *
     * @return JsonResponse
     */
    public function index($league_id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {

            $albums = $this->dispatchFromArray(ReadLeaguePhotoAlbumsCommand::class, ['user_id' => $user->id, 'league_id' => $league_id]);

            return $this->respond([
                'data' => $this->leaguePhotoAlbumTransformer->transformCollection($albums)
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @api               {post} api/leagues/:leagueId/photoAlbum Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Photo Albums
     * @apiPermission     organization, JWT
     * @apiDescription    Creates a new Photo Album for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {String} album_name Name of the photo album.
     *
     * @apiSuccess Object LeagueOrganizationPhotoAlbums
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Album created successfully!'
     *     }
     *
     * @apiUse LeagueNotFound
     *
     * @param CreateLeaguePhotoAlbumRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeaguePhotoAlbumRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $this->dispatchFrom(CreateLeaguePhotoAlbumsCommand::class, $request, [ 'user_id' => $user_id]);

            return $this->respond([
                'data' => "Album created successfully!"
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @api               {post} api/leagues/:leagueId/photoAlbum/:album_id Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          League Photo Albums
     * @apiPermission     organization, JWT
     * @apiDescription    Update Photo Album for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} album_id Album id of the album.
     * @apiParam {String} album_name Name of the photo album.
     *
     * @apiSuccess Object LeagueOrganizationPhotoAlbums
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Album update successfully!'
     *     }
     *
     * @apiUse LeagueNotFound
     *
     * @param UpdateLeaguePhotoAlbumRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateLeaguePhotoAlbumRequest $request)
    {

        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $this->dispatchFrom(UpdateLeaguePhotoAlbumsCommand::class, $request, [ 'user_id' => $user_id]);

            return $this->respond([
                'data' => "Album update successfully!"
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/photoAlbum/:album_id Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Photo Albums
     * @apiPermission     organization, JWT
     * @apiDescription    Delete Photo Album for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} album_id Album id of the album.
     * @apiParam {String} album_name Name of the photo album.
     *
     * @apiSuccess Object LeagueOrganizationPhotoAlbums
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Album deleted successfully!'
     *     }
     *
     * @apiUse LeagueNotFound
     * @apiUse DatabaseException
     *
     * @param UpdateLeaguePhotoAlbumRequest $request
     *
     * @return JsonResponse
     */
    public function destroy($league_id, $albumId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $this->dispatchFromArray(DeleteLeaguePhotoAlbumsCommand::class,[ 'league_id' => $league_id, 'album_id' => $albumId]);

            return $this->respond([
                'data' => "Album deleted successfully!"
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }catch (DatabaseException $e) {

            return $this->respondInternalError($e->getMessage());

        }
    }
}
