<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Mailbox\CreateMailboxConversationMessageRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxConversationMessageRequest;
use Wooter\Commands\Mailbox\ReadMailboxInboxConversationMessagesCommand;
use Wooter\Commands\Mailbox\CreateMailboxConversationMessageCommand;
use Wooter\Wooter\Transformers\Mailbox\MailboxConversationMessagesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

final class MailboxInboxConversationMessagesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $mailboxConversationMessagesTransformer;
    
    public function __construct(MailboxConversationMessagesTransformer $mailboxConversationMessagesTransformer) 
    {
        $this->mailboxConversationMessagesTransformer = $mailboxConversationMessagesTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($conversation_id)
    { 
        $user = JWTAuth::parseToken()->authenticate();
        $offset = Request::get('offset');
        $limit = Request::get('limit');
        
        try {
            $messages = $this->dispatchFromArray(ReadMailboxInboxConversationMessagesCommand::class, ['userId' => $user->id, 'conversation_id' => $conversation_id, 'offset' => $offset, 'limit' => $limit]);
            
            return $this->respond([
                'data' => $this->mailboxConversationMessagesTransformer->transformCollection($messages)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateMailboxConversationMessageRequest $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $message = $this->dispatchFrom(CreateMailboxConversationMessageCommand::class, $request, ['userId' => $user->id, 'conversation_id' => $id]);

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
    public function update(UpdateMailboxConversationMessageRequest $updateMailboxConversationMessageRequest, $id)
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
