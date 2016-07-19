<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Http\Controllers\Controller;
use Wooter\Http\Requests\Mailbox\CreateMailboxRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class MailboxController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        $user = JWTAuth::parseToken()->authenticate();
    }

    public function store(CreateMailboxRequest $createMailboxRequest)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /** eturn \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMailboxRequest $updateMailboxRequest, $id)
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
        
    }
}
