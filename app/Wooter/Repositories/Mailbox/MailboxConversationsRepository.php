<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\MailboxConversation;
use Wooter\MailboxConversationMessage;
use Carbon\Carbon;

class MailboxConversationsRepository
{

    public function create(MailboxConversation $conversation)
    {
        return $conversation->save();
    }

    public function update(MailboxConversation $conversation)
    {
        return $conversation->save();
    }

    public function getById($conversationId) {
        return MailboxConversation::whereId($conversationId)->first();
    }

    public function getByFilters($conversations, $filters, $user_id)
    {
        $conversations = $this->getByTitle($conversations, $filters['keywords']);
        $conversations = $this->getByAuthor($conversations, $filters['sent'], $user_id);
        $conversations = $this->getByLatestMessagesDate($conversations, $filters);


        return $conversations;
    }
    
    public function getByTitle($conversations, $keywords)
    {
        if ($conversations->count()) {
            if ($keywords) {
                $ids = $conversations->lists('id')->toArray();

                return MailboxConversation::whereIn('id', $ids)
                                          ->where('title', 'LIKE', $keywords . '%')
                                          ->get();
            }

            return $conversations;
        }
        
        return collect([]);
    }
    
    public function getByAuthor($conversations, $sent, $user_id)
    {
        if ($conversations->count()) {
            if ($sent) {
                $ids  = $conversations->lists('id')->toArray();
                return MailboxConversation::whereIn('id', $ids)
                                           ->where('user_id', $user_id)
                                           ->get();
            }

            return $conversations;
        }
        
        return collect([]);
    }
    
    public function getByLatestMessagesDate($conversations, $timeframe, $offset, $limit)
    {       
        $dates      = $this->$timeframe();
        $collection = [];
        if ($conversations->count()){
            if ($dates){
                foreach($conversations as $conversation) {
                    $message = $conversation->messages()
                                            ->orderBy('id', 'DESC')
                                            ->first();
                    
                    $message = MailboxConversationMessage::where('id', '=', $message->id)
                                                         ->whereBetween('created_at', [$dates['start'], $dates['end']])
                                                         ->first();
                    
                    if ($message) {
                        $collection[] = $message->conversation;
                    }
                }
            }
        }
        
        $conversations = collect($collection)->sortByDesc('updated_at');
        return ($limit > 0) ? $conversations->slice($offset, $limit) : $conversations;
    }
    
    public function today() {
        return [
            'start' => Carbon::today(),
            'end'   => Carbon::now()
        ];
    }
    
    public function yesterday() {
        return [
            'start' => Carbon::yesterday(),
            'end'   => Carbon::yesterday()
                             ->hour(23)
                             ->minute(59)
                             ->second(59)
        ];
    }
    
    public function pastWeek() {
        return [
            'start' => Carbon::today()->subWeek(),
            'end'   => Carbon::now()
        ];
    }
    
    public function pastMonth() {
        return [
            'start' => Carbon::today()->subMonth(),
            'end'   => Carbon::now()
        ];
    }
    
    public function pastYear() {
        return [
            'start' => Carbon::today()->subYear(),
            'end'   => Carbon::now()
        ];
    }
    
    public function allTime() {
        return [
            'start' => '0000-00-00 00:00:00',
            'end'   => Carbon::now()
        ];
    }
    
}
