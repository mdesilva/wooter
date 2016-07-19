<?php

namespace Wooter\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Wooter\User;
use Exception;

class JWTTestController extends Controller
{


    public function __construct() {


        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
            'grabtoken',
        ]]);

        $this->middleware('jwt.auth', ['except' => [
            'index',
            'grabtoken',
        ]]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = $this::grabtoken();
        return view('fake.test',['token'=>$token]);
        //
    }
    public function grabtoken()
    {
        // grab credentials from the request
        // $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::fromUser(User::first())) {
                return 'invalid user';
            }
        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            return "could_not_create_token";
        }

        // all good so return the token
        return $token;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id="")
    {
        return response( "HELLO",200);
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
