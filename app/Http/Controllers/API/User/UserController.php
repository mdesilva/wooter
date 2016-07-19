<?php

namespace Wooter\Http\Controllers\API\User;

use Exception;
use Illuminate\Http\Request as RequestObject;
use Illuminate\Support\Facades\Request;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\User\UpdateUserRequest;
use Wooter\Commands\User\ReadUsersCommand;
use Wooter\Commands\User\ReadUserCommand;
use Wooter\Commands\User\ReadAllUsersCommand;
use Wooter\Commands\User\UpdateUserCommand;
use Wooter\Commands\User\DeleteUserCommand;
use Wooter\Wooter\Transformers\User\UserTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class UserController extends ApiController
{

    private $userTransformer;
    
    public function __construct(UserTransformer $userTransformer) 
    {
        $this->userTransformer = $userTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
        try {
            $users = $this->dispatchFrom(ReadUsersCommand::class, new RequestObject(Request::all()));

            return $this->respond([
                'data' => $this->userTransformer->transformCollection($users)
            ]);

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
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $user = $this->dispatchFromArray(ReadUserCommand::class, ['userId' => $user->id, 'id' => $id]);

            return $this->respond([
                'data' => $this->userTransformer->transform($user)
            ]);
            
        } catch (Exception $ex) {

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $updateUserRequest
     * @param  int              $id
     *
     * @return \Illuminate\Http\Response
     * @internal param RequestObject $request
     */
    public function update(UpdateUserRequest $updateUserRequest, $id)
    {
        $this->error = false;
        try
        {
            $user = $this->dispatchFrom(UpdateUserCommand::class, $updateUserRequest, ['user_id' => $id]);
            
            return $this->respond([
                'data' => $this->userTransformer->transform($user)
            ]);

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        // return [
        //     'success' => ! $this->error,
        //     'error' => $this->error,
        //     'content' => $this->content
        // ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->dispatchFromArray(DeleteUserCommand::class,['user_id' => $id]);
            return $this->respond([
                'data' => 'Deleted successfully'
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
