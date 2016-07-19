<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Organization\League\CreateLeaguePrivateInviteCommand;
use Wooter\Http\Requests\Organization\League\CreateLeaguePrivateInviteRequest;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePlayerAlreadyInvited;
use Tymon\JWTAuth\Facades\JWTAuth;


final class LeaguePrivateInvitesController extends ApiController
{
    public function __construct() {
        $this->middleware('jwt.auth');
        $this->middleware('user.is_organization');
    }

    /**
     * @api               {post} api/leagues/:leagueId/invite Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Private Invites
     * @apiPermission     organization, organization staff, requires JWT 
     * @apiDescription    Invites Player to join league.
     *
     * @apiParam {Number} league_id Id of the league
     * @apiParam {String} email Email of the player to send invitation
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Player invited successfully',
     *          'message' => 'Player invited successfully'
     *     }
     *
     * @apiUse            LeaguePhotoNotFound
     * @apiUse            LeaguePlayerAlreadyInvited
     *
     *
     * @param CreateLeaguePrivateInviteRequest $request, $league_id
     *
     * @return array
     */
    function invite(CreateLeaguePrivateInviteRequest $request, $league_id)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFrom(CreateLeaguePrivateInviteCommand::class, $request, ['league_id' => $league_id,'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Player invited successfully',
                'message' => 'Player invited successfully'
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePlayerAlreadyInvited $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
