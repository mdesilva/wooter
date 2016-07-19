<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;

use Wooter\Commands\ReadSportsCommand;
use Wooter\Http\Requests;
use Wooter\Wooter\Transformers\SportTransformer;

final class SportsController extends ApiController
{
    /**
     * @var SportTransformer
     */
    private $sportTransformer;

    /**
     * @param SportTransformer $sportTransformer
     */
    public function __construct(SportTransformer $sportTransformer) {

        $this->middleware('jwt.auth');

        $this->middleware('user.is_admin', ['except' => [
           'index',
           'show',
        ]]);

        $this->sportTransformer = $sportTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $sports = $this->dispatchFromArray(ReadSportsCommand::class, []);

            return $this->respond([
                'data' => $this->sportTransformer->transformCollection($sports)
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
