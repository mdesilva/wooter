<?php

namespace Wooter\Http\Controllers\API\Files;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

class Views extends Controller{

    public function getView($view){

        return response()->view($view)->header('Content-Type', 'text/html');
    }

}
