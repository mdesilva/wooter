<?php

namespace Wooter\Http\Controllers\API\Competition\Season;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Competition\Season\CreateSeasonCompetitionGameRequest;
use Wooter\Commands\Competition\Season\CreateSeasonCompetitionGameCommand;
use Wooter\Wooter\Transformers\Game\GamesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class SeasonCompetitionGamesController extends Controller
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

    
    public function store(CreateSeasonCompetitionGameRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $game = $this->dispatchFromArray(CreateSeasonCompetitionGameCommand::class, ['user_id' => $user->id, 'request' => new RequestObject(Request::all())]);

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

    }
}
