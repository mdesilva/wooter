<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtImageRequest;
use Wooter\Http\Requests\Court\UpdateCourtImageRequest;
use Wooter\Commands\Court\ReadCourtImagesCommand;
use Wooter\Commands\Court\ReadCourtImageCommand;
use Wooter\Commands\Court\CreateCourtImageCommand;
use Wooter\Wooter\Transformers\Court\CourtImageTransformer;

final class CourtImagesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtImageTransformer;
    
    public function __construct(CourtImageTransformer $courtImageTransformer) 
    {
        $this->courtImageTransformer = $courtImageTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $images = $this->dispatchFromArray(ReadCourtImagesCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtImagesTransformer->transformCollection($Images)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtImageRequest $request)
    {
        try {
            $image = $this->dispatchFrom(CreateCourtImageCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtImageTransformer->transform($Image)
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
    public function show($image_id)
    {
        try {
            $image = $this->dispatchFrom(ReadCourtImageCommand::class, $request, ['userId' => 1, 'image_id' => $image_id]);

            return $this->respond([
                'data' => $this->courtImageTransformer->transform($image)
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
    public function update(UpdateCourtImageRequest $request, $id)
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
