<?php

namespace Wooter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

class PrimaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public static function index(Request $request){
        $data = [
            'es6_support' => ($request->cookie('es6') !== "false" || is_null($request->cookie('es6')))
        ];
        
        return view('app', $data);
    }

    public function homepage(){
        $data = [
            'title'=> 'Homepage',
            'static_page' => 'landing/homepage',
            'js' => [],
            'css' => []
        ];
        return view('landing/template',$data);
    }

}
