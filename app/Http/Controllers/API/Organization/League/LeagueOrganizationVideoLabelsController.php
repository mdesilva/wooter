<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Illuminate\Http\JsonResponse;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Http\Requests\Organization\League\CreateLeagueVideoLabelRequest;
use Wooter\Http\Requests\Organization\League\UpdateLeagueVideoLabelRequest;
use Wooter\Commands\Organization\League\CreateLeagueVideoLabelsCommand;
use Wooter\Commands\Organization\League\ReadLeagueVideoLabelsCommand;
use Wooter\Commands\Organization\League\UpdateLeagueVideoLabelsCommand;
use Wooter\Commands\Organization\League\DeleteLeagueVideoLabelsCommand;
use Wooter\Wooter\Transformers\Organization\League\LeagueVideoLabelTransformer;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\DatabaseException;

class LeagueOrganizationVideoLabelsController extends ApiController
{

    private $leagueVideoLabelTransformer;

    public function __construct(LeagueVideoLabelTransformer $leagueVideoLabelTransformer)
    {
        $this->leagueVideoLabelTransformer = $leagueVideoLabelTransformer;
        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * @api               {get} api/leagues/:leagueId/videoLabel Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, JWT Auth
     * @apiGroup          League Video Labels
     * @apiDescription    Returns the LeagueOrganization Video Labels
     *
     * @apiParam {Number} leagueId Id of the league.
     *
     * @apiSuccess Object LeagueVideoLabels
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'name' => 'Finals',
     *              },
     *              {
     *                  'id' => 2,
     *                  'name' => 'Semi-Finals',
     *              }
     *          ]
     *     }
     * @apiUse            LeagueNotFound
     *
     * @param $league_id
     *
     * @return JsonResponse
     */
    public function index($league_id)
    {

        $user = JWTAuth::parseToken()->authenticate();

        try {
            $labels = $this->dispatchFromArray(ReadLeagueVideoLabelsCommand::class, ['user_id' => $user->id, 'league_id' => $league_id]);

            return $this->respond([
                'data' => $this->leagueVideoLabelTransformer->transformCollection($labels)
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     /**
     * @api               {get} api/leagues/:leagueId/videoLabel Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiPermission     organization, organization staff, JWT Auth
     * @apiGroup          League Video Labels
     * @apiDescription    Creates the video label
     *
     * @apiParam {Number} leagueId Id of the league.
     * @apiParam {String} label_name Name of the label
     *
     * @apiSuccess Object LeagueOrganizationVideoLabels
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => "Label created successfully!"
     *     }
     * @apiUse            LeagueNotFound
     *
     * @param CreateLeagueVideoLabelRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueVideoLabelRequest $request)
    {

        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $labels = $this->dispatchFrom(CreateLeagueVideoLabelsCommand::class, $request, [ 'user_id' => $user_id]);

            return $this->respond([
                'data' => $this->leagueVideoLabelTransformer->transformCollection($labels)
            ]);

        } catch (LeagueNotFound $e) {

                return $this->respondNotFound($e->getMessage());
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
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @api               {get} api/leagues/:leagueId/videoLabel/:lable_id Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiPermission     organization, organization staff, JWT Auth
     * @apiGroup          League Video Labels
     * @apiDescription    Updates the requested video label
     *
     * @apiParam {Number} leagueId Id of the league.
     * @apiParam {Number} lable_id Id of the video label
     * @apiParam {String} label_name Name of the label
     *
     * @apiSuccess Object LeagueVideoLabels
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => "Label update successfully!"
     *     }
     * @apiUse            LeagueNotFound
     *
     * @param UpdateLeagueVideoLabelRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateLeagueVideoLabelRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
           $labels = $this->dispatchFrom(UpdateLeagueVideoLabelsCommand::class, $request, [ 'user_id' => $user_id]);

            return $this->respond([
                'data' => $this->leagueVideoLabelTransformer->transformCollection($labels)
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }
    }

    /**
     * @api               {get} api/leagues/:leagueId/videoLabel/delete/:lable_id Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiPermission     organization, organization staff, JWT Auth
     * @apiGroup          League Video Labels
     * @apiDescription    Returns the League Video Labels
     *
     * @apiParam {Number} leagueId Id of the league.
     * @apiParam {Number} lable_id Id of the video label
     * @apiParam {String} label_name Name of the label
     *
     * @apiSuccess Object LeagueOrganizationVideoLabels
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => "Label deleted successfully!"
     *     }
     * @apiUse            LeagueNotFound
     * @apiUse            DatabaseException
     *
     * @param UpdateLeagueVideoLabelRequest $request
     *
     * @return JsonResponse
     */
    public function destroy($leagueId, $labelId)
    {

        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $user_id = $user->id;
            $labels = $this->dispatchFromArray(DeleteLeagueVideoLabelsCommand::class,  [ 'user_id' => $user_id, 'leagueId' => $leagueId, 'labelId' => $labelId]);

            return $this->respond([
                'data' => $this->leagueVideoLabelTransformer->transformCollection($labels)
            ]);

        } catch (LeagueNotFound $e) {

            return $this->respondNotFound($e->getMessage());
        }catch (DatabaseException $e) {

            return $this->respondInternalError($e->getMessage());

        }
    }
}
