<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Illuminate\Http\Request;
use Wooter\Commands\Organization\League\ReadLeaguePlayersCommand;
use Wooter\Commands\Player\CreatePlayerLeagueCommand;
use Wooter\Commands\Player\DeletePlayerLeagueCommand;
use Wooter\Commands\Player\ReadPlayerLeagueCommand;
use Wooter\Commands\Player\UpdatePlayerLeagueCommand;
use Wooter\Commands\Player\CreatePlayerLeagueJoinCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreatePlayerLeagueRequest;
use Wooter\Http\Requests\Player\UpdatePlayerLeagueRequest;
use Wooter\Http\Requests\Player\CreatePlayerLeagueJoinRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerPasscodeNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Transformers\Player\PlayerLeagueTransformer;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedTeamAsLeague;

class PlayerLeaguesController extends ApiController
{

    /**
     * @var PlayerLeagueTransformer
     */
    private $playerLeagueTransformer;

    /**
     * @param PlayerLeagueTransformer $playerLeagueTransformer
     */
    public function __construct(PlayerLeagueTransformer $playerLeagueTransformer) {

        $this->playerLeagueTransformer = $playerLeagueTransformer;
    }

    /**
     * @param CreatePlayerLeagueJoinRequest $request
     * @param $player_id
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function playerJoinLeague(CreatePlayerLeagueJoinRequest $request,  $player_id)
    {

        try
        {
            $player = $this->dispatchFrom(CreatePlayerLeagueJoinCommand::class, $request, ['player_id' => $player_id]);

            return $this->respond([
                'data' => 'Player joined the league',
                'message' => 'Player joined the league',
            ]);
        } catch (PlayerNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }  catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }catch (PlayerAlreadyJoinedLeague $e) {

            return $this->respondForbidden($e->getMessage());
        } catch (PlayerAlreadyJoinedTeamAsLeague $e) {

            return $this->respondForbidden($e->getMessage());
        } catch (PlayerPasscodeNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


}
