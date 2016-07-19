<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;

use Wooter\Commands\ReadWeekdaysCommand;
use Wooter\Http\Requests;
use Wooter\Wooter\Transformers\WeekdayTransformer;

final class WeekdaysController extends ApiController
{
    /**
     * @var WeekdayTransformer
     */
    private $weekdayTransformer;

    /**
     * @param WeekdayTransformer $weekdayTransformer
     */
    public function __construct(WeekdayTransformer $weekdayTransformer) {

        $this->middleware('jwt.auth');

        $this->middleware('user.is_admin', ['except' => [
           'index',
           'show',
        ]]);

        $this->weekdayTransformer = $weekdayTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $weekdays = $this->dispatchFromArray(ReadWeekdaysCommand::class, []);

            return $this->respond([
                'data' => $this->weekdayTransformer->transformCollection($weekdays)
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
