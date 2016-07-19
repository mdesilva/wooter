<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Mailbox\CreateMailboxConversationRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxConversationRequest;
use Wooter\Wooter\Transformers\Mailbox\MailboxConversationsTransformer;
use Wooter\Commands\Mailbox\ReadMailboxTrashConversationsCommand;
use Request;

final class MailboxTrashConversationsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $mailboxConversationsTransformer;
    
    public function __construct(MailboxConversationsTransformer $mailboxConversationsTransformer) 
    {
        $this->mailboxConversationsTransformer = $mailboxConversationsTransformer;
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
            $conversations = $this->dispatchFromArray(ReadMailboxTrashConversationsCommand::class, ['userId' => $user->id, 'offset' => $offset, 'limit' => $limit, 'club_type' => $club_type, 'club_id' => $club_id, 'timeframe' => $timeframe, 'utcOffset' => $utcOffset, 'keywords' => $keywords, 'sent' => $sent]);
            
            return $this->respond([
                'data' => $this->mailboxConversationsTransformer->transformCollection($conversations)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateMailboxConversationRequest $createMailboxConversationRequest)
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
    public function update(CreateMailboxConversationRequest $createMailboxBroadcastRequest, $id)
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
