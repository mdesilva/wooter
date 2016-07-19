<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtManualTimeSlotRequest;
use Wooter\Http\Requests\Court\UpdateCourtManualTimeSlotRequest;
use Wooter\Commands\Court\ReadCourtManualTimeSlotsCommand;
use Wooter\Commands\Court\ReadCourtManualTimeSlotCommand;
use Wooter\Commands\Court\CreateCourtManualTimeSlotCommand;
use Wooter\Wooter\Transformers\Court\CourtManualTimeSlotTransformer;

final class CourtManualTimeSlotsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtManualTimeSlotTransformer;
    
    public function __construct(CourtManualTimeSlotTransformer $courtManualTimeSlotTransformer) 
    {
        $this->courtManualTimeSlotTransformer = $courtManualTimeSlotTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $slots = $this->dispatchFromArray(ReadCourtManualTimeSlotsCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtManualTimeSlotTransformer->transformCollection($slots)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtManualTimeSlotRequest $request)
    {
        try {
            $slot = $this->dispatchFrom(CreateCourtManualTimeSlotCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtTransformer->transform($slot)
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
            $slot = $this->dispatchFrom(ReadCourtManualTimeSlotCommand::class, $request, ['userId' => 1, 'slot_id' => $slot_id]);

            return $this->respond([
                'data' => $this->courtTransformer->transform($slot)
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
    public function update(UpdateCourtManualTimeSlotRequest $request, $id)
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

