<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Court\ReadCourtManualOffsCommand;
use Wooter\Commands\Court\ReadCourtManualOffCommand;
use Wooter\Commands\Court\CreateCourtManualOffCommand;
use Wooter\Wooter\Transformers\Court\CourtManualOffTransformer;

final class CourtManualOffsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtManualOffsTransformer;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $offs = $this->dispatchFromArray(ReadCourtManualOffsCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtManualOffsTransformer->transformCollection($offs)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtManualOffRequest $request)
    {
        try {
            $off = $this->dispatchFrom(CreateCourtManualOffCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtManualOffTransformer->transform($off)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($off_id)
    {
        try {
            $off = $this->dispatchFrom(ReadCourtManualOffCommand::class, $request, ['userId' => 1, 'off_id' => $off_id]);

            return $this->respond([
                'data' => $this->courtManualOffTransformer->transform($off)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /** eturn \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourtManualOffRequest $request, $id)
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
        
    }
}

