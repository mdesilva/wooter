<?php

namespace Wooter\Http\Controllers\API\Player;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Player\CreatePlayerTeamCommand;
use Wooter\Commands\Player\DeletePlayerTeamCommand;
use Wooter\Commands\Player\ReadPlayerTeamCommand;
use Wooter\Commands\Player\UpdatePlayerTeamCommand;
use Wooter\Http\Requests\Player\CreatePlayerTeamRequest;
use Wooter\Http\Requests\Player\DeletePlayerTeamRequest;
use Wooter\Http\Requests\Player\UpdatePlayerTeamRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerTeamNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Player\ReadPlayerTeamsCommand;
use Wooter\Wooter\Transformers\Player\PlayerTransformer;
use Wooter\Wooter\Transformers\Team\TeamTransformer;

final class PlayerTeamsController extends ApiController
{
    /**
     * @var TeamTransformer
     */
    private $teamTransformer;
    /**
     * @var PlayerTransformer
     */
    private $playerTransformer;

    /**
     * @param TeamTransformer   $teamTransformer
     * @param PlayerTransformer $playerTransformer
     */
    public function __construct(TeamTransformer $teamTransformer, PlayerTransformer $playerTransformer) {

        $this->teamTransformer = $teamTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
        $this->playerTransformer = $playerTransformer;
    }

    /**
     * @api               {get} api/players/:playerId/teams Index
     *  @apiVersion        1.0.0
     * @apiName           Index
     * @apiGroup          Player Team
     * @apiDescription    Returns an array of all the teams where a player plays that matches the filter parameters
     *
     * @apiSuccess {Array} data Array with all the teams.
     *
     * @apiParam {integer} [player_id] ID of the player to get the teams
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     * @apiUse            UserNotFound
     *
     * @param $playerId
     *
     * @return JsonResponse
     */
    public function index($playerId)
    {
        try {
            $orderBy = Request::get('order_by', self::DEFAULT_ORDER_BY);
            $orderDirection = Request::get('order_direction', self::DEFAULT_ORDER_DIRECTION);
            $offset = Request::get('offset', self::DEFAULT_OFFSET);
            $limit = Request::get('limit', self::DEFAULT_LIMIT);

            $teams = $this->dispatchFromArray(ReadPlayerTeamsCommand::class, ['player_id' => $playerId, 'offset' => $offset, 'limit' => $limit, 'order_by' => $orderBy, 'order_direction' => $orderDirection]);

            return $this->respond([
                'data' => $this->teamTransformer->transformCollection($teams)
            ]);
            
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * @api               {post} api/players/:playerId/teams Create
     *  @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          Player Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Links a player with a team
     *
     * @apiParam {Number} team_id ID of the team
     * @apiParam {Number} competition_id ID of the competition
     * @apiParam {Number} competition_type Type of the competition
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ],
     *          'message' => 'Success'
     *     }
     *
     * @param CreatePlayerTeamRequest $request
     * @param                         $playerId
     *
     * @return JsonResponse
     * @apiUse            UserNotFound
     *
     */
    public function store(CreatePlayerTeamRequest $request, $playerId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $playerTeam = $this->dispatchFrom(CreatePlayerTeamCommand::class, $request, ['player_id' => $playerId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($playerTeam),
                'message' => 'Success'
            ]);
        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }


    /**
     * @api               {post} api/players/:playerId/teams Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          Player Team
     * @apiPermission     Requires JWT. User needs to be organization
     * @apiDescription    Links a player with a team
     *
     * @apiParam {Number} team_id ID of the team
     * @apiParam {Number} competition_id ID of the competition
     * @apiParam {Number} competition_type Type of the competition
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ],
     *          'message' => 'Success'
     *     }
     *
     * @param UpdatePlayerTeamRequest $request
     * @param                         $playerId
     * @param                         $teamId
     *
     * @return JsonResponse
     * @apiUse            UserNotFound
     */
    public function update(UpdatePlayerTeamRequest $request, $playerId, $teamId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $player = $this->dispatchFrom(UpdatePlayerTeamCommand::class, $request, ['team_id' => $teamId, 'player_id' => $playerId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->playerTransformer->transform($player),
            ]);
        } catch (PlayerNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (TeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/players/:playerId/teams/:teamId Read
     *  @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          Player Team
     * @apiDescription    Gets a team that a player is playing in
     *
     * @apiParam {Number} player_id Id of the Player
     * @apiParam {Number} team_id Id of the Team
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     *
     * @apiUse            TeamNotFound
     * @apiUse            UserNotFound
     *
     * @param $playerId
     * @param $teamId
     *
     * @return JsonResponse
     */
    public function show($playerId, $teamId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $team = $this->dispatchFromArray(ReadPlayerTeamCommand::class, ['player_id' => $playerId, 'team_id' => $teamId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => $this->teamTransformer->transform($team)
            ]);
        } catch (PlayerTeamNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
