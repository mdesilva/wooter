<?php

namespace Wooter\Http\Controllers;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\ReadVideoMediaCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueVideoTransformer;
use Wooter\Wooter\Exceptions\VideoNotFound;


final class VideoMediaController extends ApiController
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

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($video_id)
    {
        try
        {

            $video = $this->dispatchFromArray(ReadVideoMediaCommand::class, ['video_id'=> $video_id]);


            return $this->respond([
                'data' => $this->leagueVideoTransformer->transform($video)
            ]);

        } catch (VideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        }
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
