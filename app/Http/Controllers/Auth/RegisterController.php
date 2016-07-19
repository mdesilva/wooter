<?php

namespace Wooter\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Wooter\Commands\User\RegisterUserCommand;
use Wooter\FirstSetup;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\RegisterUserRequest;
use Wooter\Role;
use Wooter\User;
use Illuminate\Support\Facades\Auth;
use Wooter\Wooter\Traits\Responder;
use Wooter\Wooter\Transformers\User\UserTransformer;

class RegisterController extends Controller
{
    use Responder;

    /**
     * @var userTransformer
     */
    private $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     *
     * @internal param UserTransformer $UserTransformer
     */
    public function __construct(UserTransformer $userTransformer) {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @api               {post} register Create
     * @apiVersion        1.0.0
     * @apiName           register
     * @apiGroup          Registration
     * @apiDescription    Registers a new user
     *
     * @apiParam {Integer} preselected_role Role of the user
     * @apiParam {String} email Email of the user
     * @apiParam {String} password Password of the user
     * @apiParam {String} first_name First name of the user
     * @apiParam {String} last_name Last name of the user
     * @apiParam {String} birthday Birthday of the user
     * @apiParam {String} phone Phone of the user
     * @apiParam {String} gender Gender of the user
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => $user->id,
     *                  'email' => $user->email,
     *                  'first_name' => 'John',
     *                  'last_name' => 'Doe',
     *                  'phone' => $user->phone,
     *                  'gender' => $user->gender,
     *                  'picture' => $user->picture,
     *                  'active' => 1,
     *                  'birthday' => $user->birthday,
     *                  'is_organization' => true,
     *                  'roles' => $user->roles
     *              ]
     *          ]
     *     }
     *
     *
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->dispatch(new RegisterUserCommand($request));

            return $this->respond([
                'data' => $this->userTransformer->transform($user),
                'message' => 'Success'
            ]);

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
