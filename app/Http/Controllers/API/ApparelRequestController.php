<?php

namespace Wooter\Http\Controllers\API;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Commands\ReadApparelCommand;
use Wooter\Http\Controllers\Controller;
use Wooter\Wooter\Transformers\ApparelRequestTransformer;
use Exception;

class ApparelRequestController extends ApiController
{
    public function __construct(ApparelRequestTransformer $apparelRequestTransformer){
        $this->apparelRequestTransformer = $apparelRequestTransformer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $render = $this->dispatch(new ReadApparelCommand);    
            return $this->respond([
                'data' => $this->apparelRequestTransformer->transform($render , true)
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
