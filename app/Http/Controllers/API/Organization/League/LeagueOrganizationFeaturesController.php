<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Wooter\Commands\Organization\League\CreateLeagueFeatureCommand;
use Wooter\Commands\Organization\League\DeleteLeagueFeatureCommand;
use Wooter\Commands\Organization\League\ReadLeagueLeagueFeatureCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Http\Requests\Organization\League\CreateLeagueFeatureRequest;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeagueFeatureTransformer;


final class LeagueOrganizationFeaturesController extends ApiController
{
    /**
     * @var LeagueFeatureTransformer
     */
    private $leagueFeatureTransformer;

    /**
     * LeagueFeatureController constructor.
     *
     * @param LeagueFeatureTransformer $leagueFeatureTransformer
     */
    function __construct (LeagueFeatureTransformer $leagueFeatureTransformer) {
        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization');

        $this->leagueFeatureTransformer = $leagueFeatureTransformer;
    }

    /**
     * @api               {get} api/leagues/:leagueId/features Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiGroup          League Feature
     * @apiDescription    Returns the League Features for the League
     *
     * @apiParam {Number} leagueId League id of the league.
     *
     * @apiSuccess Object LeagueFeature
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'league_id' => 1,
     *                  'league_feature_id' => 1,
     *                  'name' => 'Referees',
     *                  'icon' => 'test/icon/name.png'
     *              },
     *              {
     *                  'id' => 2,
     *                  'league_id' => 2,
     *                  'league_feature_id' => 2,
     *                  'name' => 'Referees',
     *                  'icon' => 'test/icon/name.png'
     *              }
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId){
        try{
            $leagueFeatures = $this->dispatchFromArray(ReadLeagueLeagueFeatureCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueFeatureTransformer->transformCollection($leagueFeatures)
            ]);
        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/features Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Feature
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Creates a new League Feature for the League
     *
     * @apiParam {Number} leagueId League id of the league to save the feature
     * @apiParam {String} name Name of the feature
     * @apiParam {String} icon Icon of the feature
     *
     * @apiSuccess        Object LeagueFeature
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'league_id' => 1,
     *              'league_feature_id' => 1,
     *              'name' => 'Referees',
     *              'icon' => 'test/icon/name.png',
     *          ]
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param CreateLeagueFeatureRequest $request , $leagueId
     *
     * @param                            $leagueId
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueFeatureRequest $request, $leagueId) {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueFeature = $this->dispatchFrom(CreateLeagueFeatureCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueFeatureTransformer->transform($leagueFeature)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @api               {delete} api/leagues/:leagueId/features/:feature Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          League Feature
     * @apiPermission     organization, organization staff, JWTAuth
     * @apiDescription    Deletes the league feature
     *
     * @apiParam {Number} leagueId league id of the league
     * @apiParam {Number} feature feature id to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'success' => 'true'
     *     }
     *
     * @apiUse            LeagueNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     * @param $leagueId , $feature
     *
     * @param $featureId
     *
     * @return JsonResponse
     */
    public function destroy($leagueId, $featureId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteLeagueFeatureCommand::class, ['user_id' => $user->id, 'league_id' => $leagueId, 'feature_id' => $featureId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
