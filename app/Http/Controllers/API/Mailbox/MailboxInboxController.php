<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Mailbox\CreateMailboxInboxRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxInboxRequest;
use Wooter\Commands\Mailbox\ReadMailboxInboxCommand;
use Wooter\Wooter\Transformers\Mailbox\MailboxInboxTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class MailboxInboxController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    public function __construct(MailboxInboxTransformer $mailboxInboxTransformer){
        $this->mailboxInboxTransformer = $mailboxInboxTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
                $inbox = $this->dispatchFromArray(ReadMailboxInboxCommand::class, ['userId' => $user->id]);
       
                return $this->respond([
                    'data' => $this->mailboxInboxTransformer->transform($inbox)
                ]);
                
            } catch (Exception $ex) {
       
        }
   }
    
    public function store(CreateMailboxInboxRequest $createMailboxInboxRequest)
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
