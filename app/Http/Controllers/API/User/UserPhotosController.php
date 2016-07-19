<?php

namespace Wooter\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\User\CreateUserPhotoCommand;
use Wooter\Http\Requests\User\CreateUserPhotoRequest;
use Wooter\Wooter\Transformers\User\UserTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Wooter\Traits\Responder;

class UserPhotosController extends Controller
{
    use Responder;
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
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserPhotoRequest $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $userPhoto = $this->dispatchFrom(CreateUserPhotoCommand::class, $request, ['user_id' => $user->id]);

            return $this->respond([
                'data' => 'success'
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
