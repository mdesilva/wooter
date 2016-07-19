<?php

namespace Wooter\Http\Controllers\API\Player;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Player\CreatePlayerBasketballStatRequest;
use Wooter\Http\Requests\Player\UpdatePlayerBasketballStatRequest;
use Wooter\Commands\Player\ReadPlayerBasketballStatCommand;
use Wooter\Commands\Player\CreatePlayerBasketballStatCommand;
use Wooter\Wooter\Transformers\Player\PlayerBasketballStatTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Request;

class PlayerBasketballStatsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    public function __construct(PlayerBasketballStatTransformer $playerBasketballStatTransformer){
        $this->playerBasketballStatTransformer = $playerBasketballStatTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        $user = JWTAuth::parseToken()->authenticate();

        try {
                $stats = $this->dispatchFromArray(ReadPlayerBasketballPlayerCommand::class, ['userId' => $user->id]);
       
                return $this->respond([
                    'data' => $this->playerBasketballStatTransformer->transform($stats)
                ]);
                
            } catch (Exception $ex) {
       
        }
   }
    
    public function store(CreatePlayerBasketballStatRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {
                $stats = $this->dispatchFrom(CreatePlayerBasketballStatCommand::class, $request, ['user_id' => $user->id]);

                return $this->respond([
                    'data' => $this->playerBasketballStatTransformer->transformCollection($stats)
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
    public function show($id)
    {
        
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
    public function update(UpdatePlayerBasketballStatRequest $request, $id)
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


