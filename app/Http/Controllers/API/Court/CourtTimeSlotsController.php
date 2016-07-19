<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtTimeSlotRequest;
use Wooter\Http\Requests\Court\UpdateCourtTimeSlotRequest;
use Wooter\Commands\Court\ReadCourtTimeSlotsCommand;
use Wooter\Commands\Court\ReadCourtTimeSlotCommand;
use Wooter\Commands\Court\CreateCourtTimeSlotCommand;
use Wooter\Wooter\Transformers\Court\CourtTimeSlotTransformer;

final class CourtTimeSlotsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtTimeSlotTransformer;
    
    public function __construct(CourtTimeSlotTransformer $courtTimeSlotTransformer) 
    {
        $this->courtTimeSlotTransformer = $courtTimeSlotTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $slots = $this->dispatchFromArray(ReadCourtTimeSlotsCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtTimeSlotsTransformer->transformCollection($slots)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtTimeSlotRequest $request)
    {
        try {
            $slot = $this->dispatchFrom(CreateCourtTimeSlotCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtTimeSlotTransformer->transform($slot)
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
    public function show($slot_id)
    {
        try {
            $slot = $this->dispatchFrom(ReadCourtTimeSlotCommand::class, $request, ['userId' => 1, 'slot_id' => $slot_id]);

            return $this->respond([
                'data' => $this->courtTimeSlotTransformer->transform($slot)
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
    public function update(UpdateCourtTimeSlotRequest $request, $id)
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

