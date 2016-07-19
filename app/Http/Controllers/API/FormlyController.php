<?php

namespace Wooter\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

class FormlyController extends Controller
{
    protected $token = 'e302843af2e430354dba0afe38abae6db426337f';
    private $users = [
        'alinus',
        'carlos',
        'diaz',
        'demoUser'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $file = base_path('/formly-generator');
        if(file_exists($file)){
            $return = view('formly-generator');
        } else {
            $return = "Formly Generator not is installed, run composer update to install";
        }

        return $return;
    }

    public function login(){
        $input_style = 'style="padding: 10px 15px; display: block; width: 100%; -webkit-border-radius: ;-moz-border-radius: ;border-radius: 3px; margin-bottom:20px; border: 1px solid #dedede;"';
        $render = '<title>Formly Login</title><center><h1 style="margin: 40px 0;font-family: sans-serif;">Formly Login</h1><form action="'.request()->url().'" method="POST" style="width: 320px;" autocomplete="off">';
        $render .= csrf_field();
        $render .= '<input type="text" required name="token" value="'.old('token').'" placeholder="Enter secure token:" '.$input_style.'>';
        $render .= '<input type="text" equired name="user" value="'.old('user').'" placeholder="Enter username:" '.$input_style.'>';
        $render .= '<input type="password" equired name="pass" placeholder="Enter password:" '.$input_style.'>';
        $render .= '<input type="submit" style="height: 40px;line-height: 40px; cursor: pointer;width: 100%;text-align: center;background: #f0f0f0; border: 1px solid #dedede; border-radius: 3px; float: right;" value="Get Access">';
        $render .= '</form></center>';

        return $render;
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
        $exist_cond = array_search($request->input('user'), $this->users);
        $token_cond = ($request->token == $this->token)?true:false;
        $auth_cond  = ($request->input('pass') == strtolower($request->input('user')).$this->token)?true:false;
        if($token_cond){
            if(is_numeric($exist_cond) && $exist_cond >= 0){
                if($auth_cond){
                    $response = new Response('<p>All are good, this session expire in 30 minutes. Go to <a href="'.url('/formly-generator').'">Formly Generator</a></p>');
                    $response->withCookie('formlyGenerator', $this->token.csrf_token(), 30);

                    return $response;
                } else {
                    echo '<p>Sorry your password not is good!<a href="'.url('/formly-generator/login').'">Go back</a></p></p>';
                }
            } else {
                echo '<p>This user don\'t exist! <a href="'.url('/formly-generator/login').'">Go back</a></p>';
            }
        } else {
            echo '<p>Sorry your token not is good, don\'t have access here!<a href="'.url('/formly-generator/login').'">Go back</a></p></p>';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type, $file){
        $filename = base_path('/formly-generator/'.implode('.min', explode('/min', implode('/', explode('.', $file)))).'.'.$type);
        $filename = implode('.', explode('---', $filename));

        if(file_exists($filename)){
            return response(file_get_contents($filename), 200)->header('Content-Type', 'text/'.(($type == 'css')?'css':'javascript'));
        } else {
            return $filename;
        }
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
