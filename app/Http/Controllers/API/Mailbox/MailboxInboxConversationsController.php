<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Mailbox\CreateMailboxConversationRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxConversationRequest;
use Wooter\Commands\Mailbox\ReadMailboxInboxConversationsCommand;
use Wooter\Commands\Mailbox\CreateMailboxConversationCommand;
use Wooter\Wooter\Transformers\Mailbox\MailboxConversationsTransformer;
use Wooter\Wooter\Transformers\Mailbox\MailboxConversationMessagesTransformer;
use Wooter\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Request;

final class MailboxInboxConversationsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $mailboxConversationsTransformer;
    
    private $mailboxConversationMessagesTransformer;
    
    public function __construct(MailboxConversationsTransformer $mailboxConversationsTransformer, 
                                MailboxConversationMessagesTransformer $mailboxConversationMessagesTransformer) 
    {
        $this->mailboxConversationsTransformer = $mailboxConversationsTransformer;
        $this->mailboxConversationMessagesTransformer = $mailboxConversationMessagesTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        $user = JWTAuth::parseToken()->authenticate();
        $club_type = Request::get('club_type');
        $club_id = Request::get('club_id');
        $timeframe = Request::get('timeframe');
        $utcOffset = Request::get('utcOffset');
        $keywords = Request::get('keywords');
        $sent = Request::get('sent');
        $offset = Request::get('offset');
        $limit = Request::get('limit');
        
        try {
            $conversations = $this->dispatchFromArray(ReadMailboxInboxConversationsCommand::class, ['userId' => $user->id, 'offset' => $offset, 'limit' => $limit, 'club_type' => $club_type, 'club_id' => $club_id, 'timeframe' => $timeframe, 'utcOffset' => $utcOffset, 'keywords' => $keywords, 'sent' => $sent]);

            return $this->respond([
                'data' => $this->mailboxConversationsTransformer->transformCollection($conversations)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateMailboxConversationRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $message = $this->dispatchFrom(CreateMailboxConversationCommand::class, $request, ['userId' => $user->id]);

            return $this->respond([
                'data' => $this->mailboxConversationMessagesTransformer->transform($message)
            ]);
            
        } catch (Exception $ex) {

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
    public function update(UpdateMailboxConversationRequest $updateMailboxConversationRequest, $id)
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
