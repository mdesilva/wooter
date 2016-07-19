<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as RequestObject;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\League\CreateLeagueReviewCommand;
use Wooter\Commands\Organization\League\ReadLeagueReviewCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Organization\League\CreateLeagueReviewRequest;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeagueReviewTransformer;

final class LeagueOrganizationReviewsController extends ApiController
{
    /**
     * @var LeagueReviewTransformer
     */
    private $leagueReviewTransformer;

    /**
     * @param LeagueReviewTransformer      $leagueReviewTransformer
     */
    public function __construct(LeagueReviewTransformer $leagueReviewTransformer) {
        $this->leagueReviewTransformer = $leagueReviewTransformer;

        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    /**
     * @api               {get} api/getAllReviews Index
     * @apiVersion        1.0.0
     * @apiName           Index
     * @apiPermission     organization, organization staff, admin
     * @apiGroup          League Review
     * @apiDescription    Returns the League Game Venue for the League
     *
     *
     * @apiSuccess        Object LeagueOrganizationReview
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              {
     *                  'id' => 1,
     *                  'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',
     *                  'league_id' => 1,
     *                  'league_name' => 'Professional Spanish Football League',
     *                  'reviewer_id' => 1,
     *                  'reviewer_name' => 'Carlos',
     *                  'created_at' => '2016-05-10 06:58:57',
     *                  'updated_at' => '2016-05-10 06:58:57',
     *              },
     *              {
     *              {
     *                  'id' => 2,
     *                  'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',
     *                  'league_id' => 2,
     *                  'league_name' => 'Calcio',
     *                  'reviewer_id' => 2,
     *                  'reviewer_name' => 'Tupac',
     *                  'created_at' => '2016-05-10 06:58:57',
     *                  'updated_at' => '2016-05-10 06:58:57',
     *              }
     *          ]
     *     }
     *
     *
     * @param $leagueId
     *
     * @return JsonResponse
     */
    public function index($leagueId)
    {
        try {
            $reviews = $this->dispatchFrom(ReadLeagueReviewCommand::class, new RequestObject(Request::all()), ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueReviewTransformer->transformCollection($reviews , true)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {post} api/leagues/:leagueId/reviews Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          League Review
     * @apiDescription    Creates a new Review for the League
     *
     * @apiParam {Number} leagueId Id of the league to save the review
     * @apiParam {String} review Review of the league
     *
     * @apiSuccess        Object LeagueOrganizationReview
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => 1,
     *              'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',
     *              'reviewer_id' => 58,
     *              'verified' => '1',
     *          ]
     *     }
     *
     * @apiUse            UserNotFound
     * @apiUse            LeagueNotFound
     *
     *
     * @param CreateLeagueReviewRequest $request , $leagueId
     *
     * @param                           $leagueId
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueReviewRequest $request, $leagueId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $leagueReview = $this->dispatchFrom(CreateLeagueReviewCommand::class, $request, ['user_id' => $user->id, 'league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->leagueReviewTransformer->transform($leagueReview)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
