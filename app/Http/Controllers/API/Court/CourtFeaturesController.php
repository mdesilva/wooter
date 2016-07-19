<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtFeatureRequest;
use Wooter\Http\Requests\Court\UpdateCourtFeatureRequest;
use Wooter\Commands\Court\ReadCourtFeatureCommand;
use Wooter\Commands\Court\CreateCourtFeatureCommand;
use Wooter\Wooter\Transformers\Court\CourtFeatureTransformer;

final class CourtFeaturesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtFeatureTransformer;
    
    public function __construct(CourtFeatureTransformer $courtFeatureTransformer) 
    {
        $this->courtFeatureTransformer = $courtFeatureTransformer;
    }
    
    
    public function store(CreateCourtFeatureRequest $request)
    {
        try {
            $feature = $this->dispatchFrom(CreateCourtFeatureCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtFeatureTransformer->transform($feature)
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
    public function show($feature_id)
    {
        try {
            $feature = $this->dispatchFrom(ReadCourtFeatureCommand::class, $request, ['userId' => 1, 'feature_id' => $feature_id]);

            return $this->respond([
                'data' => $this->courtFeatureTransformer->transform($feature)
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
    public function update(UpdateCourtFeatureRequest $request, $id)
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


