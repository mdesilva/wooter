<?php

namespace Wooter\Http\Controllers\API\Award;

use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Player\CreateAwardRequest;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Exception;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Transformers\Player\AwardTransformer;

final class AwardsController extends ApiController
{
    /**
     * @var AwardTransformer
     */
    private $awardTransformer;

    /**
     * @param AwardTransformer $awardTransformer
     */
    public function __construct(AwardTransformer $awardTransformer) {
        $this->awardTransformer = $awardTransformer;
    }

    /**
     * @api               {post} api/award Create
     * @apiVersion        1.0.0
     * @apiName           Create
     * @apiGroup          Awards
     * @apiPermission     admin
     * @apiDescription    Creates a new Award
     *
     * @apiParam {String} name Name of the user
     *
     * @apiSuccess        Object Award
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'name' => 'MVP',
     *          ]
     *     }
     *
     * @apiUse            UserNotFound
     * @apiUse            UserIsNotAdmin
     *
     *
     * @param CreateAwardRequest $request
     *
     * @return array
     */
    public function store(CreateAwardRequest $request)
    {
        try
        {
            $leagueBasics = $this->dispatchFrom(CreateAwardCommand::class, $request, ['user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => $this->awardTransformer->transform($leagueBasics)
            ]);

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/award/:awardId Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          Awards
     * @apiPermission     admin
     * @apiDescription    Gets award information
     *
     * @apiParam {Number} awardId Id of the Award
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'name' => 'MVP',
     *          ]
     *     }
     *
     *
     * @apiUse            AwardNotFound
     * @apiUse            NotPermissionException
     *
     * @param $awardId
     *
     * @return array
     */
    public function show($awardId)
    {
        try
        {
            $photo = $this->dispatchFromArray(ReadAwardCommand::class, ['league_photo_id' => $awardId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => $this->awardTransformer->transform($photo)
            ]);

        } catch (AwardNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {put} api/award/:awardId Update
     * @apiVersion        1.0.0
     * @apiName           Update
     * @apiGroup          Awards
     * @apiPermission     admin
     * @apiDescription    Updates the award
     *
     * @apiParam {Number} awardId Award id of the award to update
     * @apiParam {String} source Source path of the photo
     * @apiParam {String} name Name of the photo
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'name' => 'MVP',
     *          ]
     *     }
     *
     * @apiUse            AwardNotFound
     * @apiUse            LeagueNotBelongToUser
     *
     *
     * @param UpdateAwardRequest $request
     * @param                          $awardId
     *
     * @return array
     */
    public function update(UpdateAwardRequest $request, $awardId)
    {
        try
        {
            $award = $this->dispatchFrom(UpdateAwardCommand::class, $request, ['league_photo_id' => $awardId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => $this->awardTransformer->transform($award)
            ]);

        } catch (AwardNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {delete} api/award/:awardId Delete
     * @apiVersion        1.0.0
     * @apiName           Delete
     * @apiGroup          Awards
     * @apiPermission     admin
     * @apiDescription    Deletes the award
     *
     * @apiParam {Number} awardId Id of the award information to delete
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => 'Deleted successfully'
     *     }
     *
     * @apiUse            AwardNotFound
     * @apiUse            LeagueNotBelongToUser
     * @apiUse            DatabaseException
     *
     *
     * @param $awardId
     *
     * @return array
     */
    public function destroy($awardId)
    {
        try
        {
            $this->dispatchFromArray(DeleteAwardCommand::class,['league_photo_id' => $awardId, 'user_id' => Auth::User()->id]);

            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (AwardNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueNotBelongToUser $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
