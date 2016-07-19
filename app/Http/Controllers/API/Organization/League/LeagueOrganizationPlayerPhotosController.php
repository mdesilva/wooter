<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeaguePlayerPhotoCommand;
use Wooter\Wooter\Transformers\Organization\League\LeaguePlayerPhotosTransformer;

class LeagueOrganizationPlayerPhotosController extends ApiController
{

    private $leaguePlayerPhotosTransformer;

    public function __construct(LeaguePlayerPhotosTransformer $leaguePlayerPhotosTransformer) {

        $this->leaguePlayerPhotosTransformer = $leaguePlayerPhotosTransformer;
    }

    /**
     * @api               {get} api/leagues/:leagueId/player/:playerId/photos/:offset/limit Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Player Photos
     * @apiDescription    Returns the photos for the players of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} playerId Player id of the sport.
     * @apiParam {Number} offset Pagination
     * @apiParam {String} limit Limit of the photos.
     *
     * @apiSuccess Object LeagueOrganizationPlayerPhoto
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'league_id' => 1,
     *                  'image_id' => 3,
     *                  'album_id' => 3,
     *                  'game_id' => 2,
     *                  'file_name' => 'Darian Ryan DDS',
     *                  'file_path' => '/public/images/testphoto.jpeg',
     *                  'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',
     *                  'size' => '85002',
     *                  'mime_type' => 'application/yang',
     *                  'extension' => 'wmd',
     *                  'role' => 4,
     *                  'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',
     *              },
     *              {
     *                  'league_id' => 1,
     *                  'image_id' => 4,
     *                  'album_id' => 4,
     *                  'game_id' => 2,
     *                  'file_name' => 'Darian Ryan DDS',
     *                  'file_path' => '/public/images/testphoto.jpeg',
     *                  'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',
     *                  'size' => '85002',
     *                  'mime_type' => 'application/yang',
     *                  'extension' => 'wmd',
     *                  'role' => 4,
     *                  'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',
     *              }
     *          ]
     *     }
     *
     * @param $leagueId, $playerId, $offset, $limit
     *
     * @return JsonResponse
     */

    public function index($leagueId, $playerId, $offset = '', $limit = '')
    {
        try
        {
            $leaguePlayerPhotos = $this->dispatchFromArray(ReadLeaguePlayerPhotoCommand::class, ['league_id' => $leagueId, "player_id" => $playerId, 'limit' => $limit,  'offset' => $offset]);
            return $this->respond([
                'data' => $this->leaguePlayerPhotosTransformer->transformCollection($leaguePlayerPhotos)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
