<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Illuminate\Http\Request;

use Exception;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeaguePlayerVideoCommand;
use Wooter\Wooter\Transformers\Organization\League\LeaguePlayerVideosTransformer;

class LeaguePlayerVideosController extends ApiController
{

    private $leaguePlayerVideosTransformer;

    public function __construct(LeaguePlayerVideosTransformer $leaguePlayerVideosTransformer) {

        $this->leaguePlayerVideosTransformer = $leaguePlayerVideosTransformer;
    }
    
    /**
     * @api               {get} api/leagues/:leagueId/player/:playerId/videos/:offset/:limit Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Player Videos
     * @apiDescription    Returns the videos for the games of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} playerId Player id of the sport.
     * @apiParam {Number} offset Pagination
     * @apiParam {String} limit Limit of the photos.
     *
     * @apiSuccess Object LeagueOrganizationPlayerVideo
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'league_id' => 1,
     *                  'video_id' => 1,
     *                  'label_id' => 3,
     *                  'game_id' => 2,
     *                  'file_name' => 'Jodie Gleason',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $video->thumbnail_path,
     *                  'size' => '81686',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *              },
     *              {
     *                  'league_id' => 2,
     *                  'video_id' => 2,
     *                  'label_id' => 3,
     *                  'game_id' => 3,
     *                  'file_name' => 'Jodie Gleason',
     *                  'file_path' => '/public/videos/testvideowooter.mp4',
     *                  'thumbnail_path' => $video->thumbnail_path,
     *                  'size' => '81686',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *              }
     *          ]
     *     }
     *
     * @param $leagueId, $playerId, $offset, $limit
     *
     * @return array
     */
    public function index($leagueId, $playerId, $offset = '', $limit = '')
    {
        try
        {
            $leaguePlayerVideos = $this->dispatchFromArray(ReadLeaguePlayerVideoCommand::class, ['league_id' => $leagueId, "player_id" => $playerId, 'limit' => $limit,  'offset' => $offset]);


            return $this->respond([
                'data' => $this->leaguePlayerVideosTransformer->transformCollection($leaguePlayerVideos)
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
