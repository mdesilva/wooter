<?php

namespace Wooter\Http\Controllers\API;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function error($key){
        $view = view('errors.'.$key);
        return $view;
    }

    /**
     * @api {post} api/setLanguage Setting Website Language
     * @apiName Update Language
     * @apiGroup Language
     *
     * @apiParam {string} language="en, es" Language parameter to set language;
     */
    public function setLanguage(Request $req) {
        $data = $req->all();

        return response()->json(['success' => true], 200)->withCookie(config('translate.su_cookie_name'), $data['language']);
    }

}
