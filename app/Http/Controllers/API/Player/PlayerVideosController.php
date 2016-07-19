<?php

namespace Wooter\Http\Controllers\API\Player;

use Illuminate\Support\Facades\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Transformers\Organization\League\LeagueVideoTransformer;
use Wooter\Commands\Player\ReadPlayerVideosCommand;

final class PlayerVideosController extends ApiController
{
    private $leagueVideoTransformer;

    public function __construct(LeagueVideoTransformer $leagueVideoTransformer) {

        $this->leagueVideoTransformer = $leagueVideoTransformer;


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($player_id)
    {
        try
        {
            $offset = Request::get('offset', self::DEFAULT_OFFSET);
            $limit = Request::get('limit', self::DEFAULT_LIMIT);
            $orderBy = Request::get('order_by', self::DEFAULT_ORDER_BY);
            $orderDirection = Request::get('order_direction', self::DEFAULT_ORDER_DIRECTION);
            $orderByVideosType = Request::get('order_by_videos_type', self::DEFAULT_ORDER_BY_VIDEOS_TYPE);
            $getVideosType = Request::get('get_videos_type', self::DEFAULT_GET_VIDEOS_TYPE);

            $playerVideos = $this->dispatchFromArray(ReadPlayerVideosCommand::class, [ "player_id" => $player_id, 'offset' => $offset, 'limit' => $limit, 'orderBy' => $orderBy, 'orderDirection' => $orderDirection, 'orderByVideosType' => $orderByVideosType, 'getVideosType' => $getVideosType]);


            return $this->respond([
                'data' => ['videos' => $this->leagueVideoTransformer->transformCollection($playerVideos['videos']),
                    'pages' => $playerVideos['pages']
                ]
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
