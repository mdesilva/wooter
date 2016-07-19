<?php

namespace Wooter\Http\Controllers\API\Stage\Regular;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Game\CreateRegularStageGameRequest;
use Wooter\Commands\Game\CreateRegularStageGameCommand;
use Wooter\Commands\Game\DeleteRegularStageGameCommand;
use Wooter\Wooter\Transformers\Game\GamesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class RegularStageGamesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $gamesTransformer;
    
    public function __construct(GamesTransformer $gamesTransformer)
    {
        $this->gamesTransformer = $gamesTransformer;
        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'leagueGames',
            'show',
        ]]);
    }

    public function index()
    {

    }

    
    public function store(CreateRegularStageGameRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $game = $this->dispatchFrom(CreateRegularStageGameCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => $game ? $this->gamesTransformer->transform($game) : false
            ]);
            
        } catch (Exception $ex) {

        }
    }

    public function show($gameId)
    {

    }

    
    public function edit($gameId)
    {

    }

    public function update(UpdateLeagueGameRequest $request, $gameId)
    {

    }
    
    public function destroy($gameId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $success = $this->dispatchFromArray(DeleteGameCommand::class, ['userId' => $user->id, 'gameId' => $gameId]);

            return $this->respond([
                'data' => $success
            ]);
            
        } catch (Exception $ex) {

        }
    }
}