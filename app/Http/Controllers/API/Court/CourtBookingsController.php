<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtBookingRequest;
use Wooter\Http\Requests\Court\UpdateCourtBookingRequest;
use Wooter\Commands\Court\ReadCourtBookingsCommand;
use Wooter\Commands\Court\CreateCourtBookingCommand;
use Wooter\Wooter\Transformers\Court\CourtBookingTransformer;

final class CourtBookingsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtBookingTransformer;
    
    public function __construct(CourtBookingTransformer $courtBookingTransformer) 
    {
        $this->courtBookingTransformer = $courtBookingTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $bookings = $this->dispatchFromArray(ReadCourtBookingsCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtBookingsTransformer->transformCollection($bookings)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtBookingRequest $request)
    {
        try {
            $booking = $this->dispatchFrom(CreateCourtBookingCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtBookingTransformer->transform($booking)
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
    public function show($booking_id)
    {
        try {
            $booking = $this->dispatchFrom(ReadCourtBookingCommand::class, $request, ['userId' => 1, 'booking_id' => $booking_id]);

            return $this->respond([
                'data' => $this->courtBookingTransformer->transform($booking)
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
    public function update(UpdateCourtBookingRequest $request, $id)
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


