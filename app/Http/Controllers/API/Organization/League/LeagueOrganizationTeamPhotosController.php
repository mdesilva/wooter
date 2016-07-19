<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Illuminate\Http\Request;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\ReadLeagueTeamPhotoCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueTeamPhotosTransformer;

class LeagueOrganizationTeamPhotosController extends ApiController
{

    private $leagueTeamPhotosTransformer;

    public function __construct(LeagueTeamPhotosTransformer $leagueTeamPhotosTransformer) {

        $this->leagueTeamPhotosTransformer = $leagueTeamPhotosTransformer;
    }
    
    /**
     * @api               {get} api/leagues/:leagueId/team/:teamId/photos/:offset/:limit Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          League Team Photos
     * @apiDescription    Returns the photos for the team of the requested league
     *
     * @apiParam {Number} leagueId League id of the league.
     * @apiParam {Number} teamId Team id of the league.
     * @apiParam {Number} offset Pagination
     * @apiParam {String} limit Limit of the photos.
     *
     * @apiSuccess Object LeagueOrganizationTeamPhoto
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'league_id' => 3,
     *                  'image' => '/public/images/testphoto.jpeg',
     *                  'album_id' => 2,
     *                  'game_id' => 2,
     *                  'team_id' => 2,
     *                  'division_id' => 2,
     *              },
     *              {
     *                  'id' => 2,
     *                  'league_id' => 2,
     *                  'image' => '/public/images/testphoto.jpeg',
     *                  'album_id' => 2,
     *                  'game_id' => 2,
     *                  'team_id' => 2,
     *                  'division_id' => 2,*              }
     *          ]
     *     }
     *
     * @param $leagueId, $playerId, $offset, $limit
     *
     * @return JsonResponse
     */
    public function index($leagueId, $teamId, $offset = '', $limit = '')
    {
        try
        {
            $leagueTeamPhotos = $this->dispatchFromArray(ReadLeagueTeamPhotoCommand::class, ['league_id' => $leagueId, "team_id" => $teamId, 'limit' => $limit,  'offset' => $offset]);
            return $this->respond([
                'data' => $this->leagueTeamPhotosTransformer->transformCollection($leagueTeamPhotos)
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
