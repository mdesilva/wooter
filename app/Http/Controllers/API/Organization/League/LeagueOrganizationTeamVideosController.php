<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Illuminate\Http\Request;

use Exception;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueTeamVideoCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueTeamVideosTransformer;

class LeagueOrganizationTeamVideosController extends ApiController
{

    private $leagueTeamVideosTransformer;

    public function __construct(LeagueTeamVideosTransformer $leagueTeamVideosTransformer) {

        $this->leagueTeamVideosTransformer = $leagueTeamVideosTransformer;


    }
    
    /**
     * @api               {get} api/leagues/:leagueId/team/:teamId/videos/:offset/:limit Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Player Videos
     * @apiDescription    Returns the videos for the team of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} teamId Team id of the league.
     * @apiParam {Number} offset Pagination
     * @apiParam {String} limit Limit of the photos.
     *
     * @apiSuccess Object LeagueOrganizationTeamVideo
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
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
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
     *                  'thumbnail_path' => $leagueTeamVideo->thumbnail_path,
     *                  'size' => '81686',
     *                  'mime_type' => 'application/vnd.lotus-screencam',
     *                  'extension' => 'igl',
     *              }
     *          ]
     *     }
     *
     * @param $leagueId, $teamId, $offset, $limit
     *
     * @return array
     */
    public function index($leagueId, $teamId, $offset = '', $limit = '')
    {
        try
        {
            $leagueTeamVideos = $this->dispatchFromArray(ReadLeagueTeamVideoCommand::class, ['league_id' => $leagueId, "team_id" => $teamId, 'limit' => $limit,  'offset' => $offset]);


            return $this->respond([
                'data' => $this->leagueTeamVideosTransformer->transformCollection($leagueTeamVideos)
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
