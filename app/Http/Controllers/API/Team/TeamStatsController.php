<?php

namespace Wooter\Http\Controllers\API\Team;

use Exception;
use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Team\UpdateTeamStatsCommand;
use Wooter\Wooter\Transformers\Team\TeamStatsTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeamStatsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $teamStatsTransformer;
    
    public function __construct(TeamStatsTransformer $teamStatsTransformer)
    {
        $this->teamStatsTransformer = $teamStatsTransformer;
        
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
        $user = JWTAuth::parseToken()->authenticate();
        $sport = $request->input('sport');
        
        
        try {
            $stats = $this->dispatchFromArray(UpdateTeamStatsCommand::class, ['userId' => $user->id, 'sport' => $sport, 'teamId' => $teamId, 'gameId' => $gameId, 'request' => $request->all()]);
  
            $this->teamStatsTransformer->sport = $sport;
            $this->teamStatsTransformer->collection = false;
            
            return $this->respond([
                'data' => $this->teamStatsTransformer->transform($stats)
            ]);
        } catch (Exception $ex) {
        }
    }
    
    public function destroy() 
    {
        
    }
}

