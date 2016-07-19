<?php

namespace Wooter\Http\Controllers\API\Team;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Team\CreateTeamLeagueJoinRequest;
use Wooter\Http\Requests\Team\CreateTeamLeagueJoinByInviteRequest;
use Wooter\Commands\Team\CreateTeamLeagueJoinCommand;
use Wooter\Commands\Team\CreateTeamLeagueJoinByInviteCommand;
use Wooter\Wooter\Exceptions\Player\PlayerPasscodeNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Team\TeamAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueInvitesNotFound;
use Illuminate\Support\Facades\Auth;
use Exception;

class TeamLeaguesController extends ApiController
{
    /**
     * @param CreateTeamLeagueJoinRequest $request
     * @param $playerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTeamLeagueJoinRequest $request, $playerId)
    {
        try
        {
            $this->dispatchFrom(CreateTeamLeagueJoinCommand::class, $request, ['player_id' => $playerId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => ['success' => 'Team has been added to league']
            ]);

        } catch (PlayerPasscodeNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }  catch (PlayerNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        } catch (TeamNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        } catch (TeamAlreadyJoinedLeague $e) {

            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {

            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * @param CreateTeamLeagueJoinByInviteRequest $request
     * @param $teamId
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     * CreateTeamLeagueJoinByInviteRequest
     */
    public function teamJoinLeagueByInvite(CreateTeamLeagueJoinByInviteRequest $request,  $teamId, $token)
    {
        try
        {
            $this->dispatchFrom(CreateTeamLeagueJoinByInviteCommand::class, $request, ['team_id' => $teamId, 'token' => $token, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => ['success' => 'Team has been added to league']
            ]);

        } catch (TeamNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }  catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }catch (PlayerNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        } catch (TeamAlreadyJoinedLeague $e) {

            return $this->respondForbidden($e->getMessage());
        } catch (Exception $e) {

            return $this->respondInternalError($e->getMessage());
        }
    }
}
