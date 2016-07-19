<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Wooter\Http\Requests;
use Illuminate\Support\Facades\Request;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueGameVideoCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueGameVideosTransformer;

class LeagueOrganizationGameVideosController extends ApiController
{

    private $leagueGameVideosTransformer;

    public function __construct(LeagueGameVideosTransformer $leagueGameVideosTransformer) {

        $this->leagueGameVideosTransformer = $leagueGameVideosTransformer;


    }
    
    /**
     * @api               {get} api/leagues/:leagueId/games/:gameId/videos/:offset/:limit Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Game Videos
     * @apiDescription    Returns the videos for the games of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} gameId Game id of the sport.
     * @apiParam {Number} offset Pagination
     * @apiParam {String} limit Limit of the photos.
     *
     * @apiSuccess Object LeagueGameVideo
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
     *                  'description' => 'Praesentium sed perspiciatis aut aut. Ullam omnis aliquam qui modi autem. Provident adipisci dolores itaque praesentium aspernatur dolorem. Explicabo nihil suscipit illo placeat dolorem ea.',
     *                  'created_at' => '2016-05-10 06:58:47',
     *                  'updated_at' => '2016-05-10 06:58:47'
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
     *                  'description' => 'Praesentium sed perspiciatis aut aut. Ullam omnis aliquam qui modi autem. Provident adipisci dolores itaque praesentium aspernatur dolorem. Explicabo nihil suscipit illo placeat dolorem ea.',
     *                  'created_at' => '2016-05-10 06:58:47',
     *                  'updated_at' => '2016-05-10 06:58:47'
     *              }
     *          ]
     *     }
     *
     * @param $leagueId, $gameId, $offset, $limit
     *
     * @return array
     */
    public function index($leagueId, $gameId, $offset = '', $limit = '')
    {
        try
        {


            $leagueGameVideos = $this->dispatchFromArray(ReadLeagueGameVideoCommand::class, ['league_id' => $leagueId, "game_id" => $gameId, 'limit' => $limit,  'offset' => $offset]);


            return $this->respond([
                'data' => $this->leagueGameVideosTransformer->transformCollection($leagueGameVideos)
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
