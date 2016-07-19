<?php

namespace Wooter\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Wooter\Events\ChatRoomCreated;
use Wooter\Http\Requests;

class SocketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('sockettest');
    }

    public function postMessage(){

        $data = [
            'channel' => 'chat_room_45',
            'chat_room_id' => 2,
            'user_from_id' => 2,
            'user_to_id' => 3,
            'message' => Request::only('message')
        ];
        event(new ChatRoomCreated($data));

        return view('sockettest');
    }



}
