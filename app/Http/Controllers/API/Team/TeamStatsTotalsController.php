<?php

namespace Wooter\Http\Controllers\API\Team;

use Exception;
use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Team\ReadTeamStatsTotalsCommand;
use Wooter\Wooter\Transformers\Team\TeamStatsTotalsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeamStatsTotalsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $teamStatsTotalsTransformer;
    
    public function __construct(TeamStatsTotalsTransformer $teamStatsTotalsTransformer)
    {
        $this->teamStatsTotalsTransformer = $teamStatsTotalsTransformer;
        
        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        
        try {
            $stats = $this->dispatchFromArray(ReadTeamStatsTotalsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'request' => $request->all()]);
  
            $this->teamStatsTotalsTransformer->sport = $sport;
            $this->teamStatsTotalsTransformer->collection = false;
            
            return $this->respond([
                'data' => $this->teamStatsTotalsTransformer->transform($stats)
            ]);
        } catch (Exception $ex) {
        }
    }

    public function store(CreateTeamStatRequest $request)
    {
        
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
    /**
     * @param $id
     */
    public function edit($id)
    {
    }
    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $teamId, $gameId)
    {
        
    }
    
    public function destroy() 
    {
        
    }
}

