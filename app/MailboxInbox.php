<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\User;
use Wooter\Mailbox;
use Wooter\MailboxBroadcast;
use Wooter\MailboxConversation;

class MailboxInbox extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailbox_inbox';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mailbox_id'
    ];
    
    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mailbox() {
        return $this->belongsTo(Mailbox::class);
    }
    
    /**
     * The conversations that belong to the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations() {
        return $this->morphToMany(MailboxConversation::class, 'container', 'mailbox_conversations_containers');
    }
    
    /**
     * The broadcasts that belong to the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function broadcasts() {
        return $this->morphToMany(MailboxBroadcast::class, 'container', 'mailbox_broadcasts_containers');
    }
    
    public function messages() {
        $messages = [];
        foreach($this->conversations as $conversation){
            foreach($conversation->messages as $message){
                if ($message){
                    $messages[] = $message;
                }
            }
        }
        return collect($messages);
    }
}

