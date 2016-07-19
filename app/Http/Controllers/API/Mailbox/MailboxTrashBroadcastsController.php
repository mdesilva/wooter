<?php

namespace Wooter\Http\Controllers\API\Mailbox;

use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests\Mailbox\CreateMailboxBroadcastRequest;
use Wooter\Http\Requests\Mailbox\UpdateMailboxBroadcastRequest;
use Wooter\Wooter\Transformers\Mailbox\MailboxBroadcastsTransformer;
use Wooter\Commands\Mailbox\ReadMailboxTrashBroadcastsCommand;
use Tymon\JWTAuth\Facades\JWTAuth;

final class MailboxTrashBroadcastsController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $mailboxBroadcastsTransformer;
    
    public function __construct(MailboxBroadcastsTransformer $mailboxBroadcastsTransformer) 
    {
        $this->mailboxBroadcastsTransformer = $mailboxBroadcastsTransformer;
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
            $broadcasts = $this->dispatchFromArray(ReadMailboxTrashBroadcastsCommand::class, ['userId' => $user->id, 'offset' => $offset, 'limit' => $limit, 'club_type' => $club_type, 'club_id' => $club_id, 'timeframe' => $timeframe, 'utcOffset' => $utcOffset, 'keywords' => $keywords, 'sent' => $sent]);
            
            return $this->respond([
                'data' => $this->mailboxBroadcastsTransformer->transformCollection($broadcasts)
            ]);
            
        } catch (Exception $ex) {

        }
    }
    
    public function store(CreateMailboxBroadcastRequest $createMailboxBroadcastRequest)
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
    public function update(UpdateMailboxBroadcastRequest $updateMailboxBroadcastRequest, $id)
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
