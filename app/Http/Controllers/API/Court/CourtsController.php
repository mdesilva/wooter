<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtRequest;
use Wooter\Http\Requests\Court\UpdateCourtRequest;
use Wooter\Commands\Court\ReadCourtsCommand;
use Wooter\Commands\Court\ReadCourtCommand;
use Wooter\Commands\Court\CreateCourtCommand;
use Wooter\Wooter\Transformers\Court\CourtTransformer;

final class CourtsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtTransformer;
    
    public function __construct(CourtTransformer $courtTransformer) 
    {
        $this->courtTransformer = $courtTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($distance, $latitude, $longitude, $offset, $limit)
    { 
        try {
            $courts = $this->dispatchFromArray(ReadCourtsCommand::class, ['userId' => 1, 'distance' => $distance, 'latitude' => $latitude, 'longitude' => $longitude, 'offset' => $offset, 'limit' => $limit]);

            return $this->respond([
                'data' => $this->courtTransformer->transformCollection($courts)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtRequest $request)
    {
        try {
            $court = $this->dispatchFrom(CreateCourtCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtTransformer->transform($court)
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
    public function show($court_id)
    {
        try {
            $court = $this->dispatchFrom(ReadCourtCommand::class, $request, ['userId' => 1, 'court_id' => $court_id]);

            return $this->respond([
                'data' => $this->courtTransformer->transform($court)
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
    public function update(UpdateCourtRequest $request, $id)
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

