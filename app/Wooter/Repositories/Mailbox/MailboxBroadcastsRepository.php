<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\MailboxBroadcast;
use Carbon\Carbon;

class MailboxBroadcastsRepository
{

    public function create(MailboxBroadcast $broadcast)
    {
        return $broadcast->save();
    }

    public function update(MailboxBroadcast $broadcast)
    {
        return $broadcast->save();
    }

    public function getById($broadcastId) {
        return MailboxBroadcast::whereId($broadcastId)->first();
    }
    
    public function getByFilters($broadcasts, $filters, $user_id)
    {
        $broadcasts = $this->getByTitle($broadcasts, $filters['keywords']);
        $broadcasts = $this->getByAuthor($broadcasts, $filters['sent'], $user_id);
        $broadcasts = $this->getByDate($broadcasts, $filters);

        return $broadcasts;
    }
    
    public function getByTitle($broadcasts, $keywords)
    {
        if ($broadcasts->count()) {
            if ($keywords) {
                $ids = $broadcasts->lists('id')->toArray();
                
                return MailboxBroadcast::whereIn('id', $ids)
                                        ->where('title', 'LIKE', $keywords . '%')
                                        ->get();
            }
            
            return $broadcasts;
        }
        
        return collect([]);
    }
    
    public function getByAuthor($broadcasts, $sent, $user_id)
    {
        if ($broadcasts->count()) {
            if ($sent) {
                $ids  = $broadcasts->lists('id')->toArray();
                return MailboxBroadcast::whereIn('id', $ids)
                                           ->where('user_id', $user_id)
                                           ->get();
            }

            return $broadcasts;
        }
        
        return collect([]);
    }
    
    public function getByDate($broadcasts, $timeframe, $offset, $limit)
    {   
        if ($broadcasts->count()) {
            if ($timeframe) {
                $dates      = $this->$timeframe();
                $ids        = $broadcasts ? $broadcasts->lists('id')->toArray() : [];
                $broadcasts = MailboxBroadcast::whereIn('id', $ids)
                                               ->whereBetween('created_at', [$dates['start'], $dates['end']])
                                               ->orderBy('id', 'DESC')
                                               ->get();
        
                return ($limit > 0) ? $broadcasts->slice($offset, $limit) : $broadcasts;
            }
            return $broadcasts;
        }
        return collect([]);
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

