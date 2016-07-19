<?php

namespace Wooter\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Exception;
use Wooter\Commands\User\LoginAsFacebookUserCommand;
use Wooter\Commands\User\LoginAsUserCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class UserManagementController extends ApiController
{
    /**
     * @api               {get} admin/user-management/login-as/:userId loginAs
     * @apiVersion        1.0.0
     * @apiName           loginAs
     * @apiGroup          User Authentication
     * @apiDescription    Returns the JWT token against user id
     *
     * @apiParam {Number} userId Id of the user.
     *
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => $token
     *     }
     * @apiUse            UserNotFound
     *
     * @param $userId
     *
     * @return JsonResponse
     */
    public function loginAs($userId)
    {
        $this->error = false;
        try
        {
            $token = $this->dispatch(new LoginAsUserCommand($userId));
            return response()->json(compact('token'));
        } catch (UserNotFound $e) {
            // $this->error = $e->getMessage();
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            // $this->error = $e->getMessage();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @api               {get} admin/user-management/login-as-facebook/:facebookUserId loginAsFacebookUser
     * @apiVersion        1.0.0
     * @apiName           loginAsFacebookUser
     * @apiGroup          User Authentication
     * @apiDescription    Returns the JWT token against facebook id
     *
     * @apiParam {Number} facebookUserId Facebook id of the user.
     *
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' => $token
     *     }
     * @apiUse            UserNotFound
     *
     * @param $facebookUserId
     *
     * @return JsonResponse
     */
    public function loginAsFacebookUser($facebookUserId)
    {
        try
        {
            $token = $this->dispatch(new LoginAsFacebookUserCommand($facebookUserId));
            return $this->respond([
                'data' => $token
            ]);
        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
