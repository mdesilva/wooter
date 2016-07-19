<?php

namespace Wooter\Http\Controllers\API\Court;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Court\CreateCourtVideoRequest;
use Wooter\Http\Requests\Court\UpdateCourtVideoRequest;
use Wooter\Commands\Court\ReadCourtVideosCommand;
use Wooter\Commands\Court\ReadCourtVideoCommand;
use Wooter\Commands\Court\CreateCourtVideoCommand;
use Wooter\Wooter\Transformers\Court\CourtVideoTransformer;

final class CourtVideosController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $courtVideoTransformer;
    
    public function __construct(CourtVideoTransformer $courtVideoTransformer) 
    {
        $this->courtVideoTransformer = $courtVideoTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        try {
            $videos = $this->dispatchFromArray(ReadCourtsCommand::class, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtTransformer->transformCollection($videos)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateCourtVideoRequest $request)
    {
        try {
            $video = $this->dispatchFrom(CreateCourtVideoCommand::class, $request, ['userId' => 1]);

            return $this->respond([
                'data' => $this->courtVideoTransformer->transform($video)
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
    public function show($video_id)
    {
        try {
            $video = $this->dispatchFrom(ReadCourtVideoCommand::class, $request, ['userId' => 1, 'video_id' => $video_id]);

            return $this->respond([
                'data' => $this->courtTransformer->transform($video)
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
    public function update(UpdateCourtVideoRequest $request, $id)
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

