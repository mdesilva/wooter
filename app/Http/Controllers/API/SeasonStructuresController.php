<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;

use Wooter\Commands\ReadCountriesCommand;
use Wooter\Commands\ReadSeasonStructuresCommand;
use Wooter\Http\Requests;
use Wooter\Wooter\Transformers\FeatureTransformer;
use Wooter\Wooter\Transformers\SeasonStructureTransformer;

final class SeasonStructuresController extends ApiController
{
    /**
     * @var SeasonStructureTransformer
     */
    private $seasonStructureTransformer;

    /**
     * @param SeasonStructureTransformer $seasonStructureTransformer
     */
    public function __construct(SeasonStructureTransformer $seasonStructureTransformer) {

        $this->middleware('jwt.auth');

        $this->middleware('user.is_admin', ['except' => [
           'index',
           'show',
        ]]);

        $this->seasonStructureTransformer = $seasonStructureTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $seasonStructures = $this->dispatchFromArray(ReadSeasonStructuresCommand::class, []);

            return $this->respond([
                'data' => $this->seasonStructureTransformer->transformCollection($seasonStructures)
            ]);

        } catch(Exception $e) {
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
