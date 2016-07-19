<?php

namespace Wooter\Http\Controllers;


use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\ReadPhotoMediaCommand;
use Wooter\Wooter\Transformers\Organization\League\LeaguePhotoTransformer;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;

class PhotoMediaController extends ApiController
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
    public function show($photo_id)
    {
        try
        {

            $photo = $this->dispatchFromArray(ReadPhotoMediaCommand::class, ['photo_id'=> $photo_id]);


            return $this->respond([
                'data' => $this->leaguePhotoTransformer->transform($photo)
            ]);

        } catch (LeaguePhotoNotFound $e) {
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
