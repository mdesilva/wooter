<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\MailboxInbox;
use Wooter\MailboxTrash;
use Wooter\MailboxConversationMessage;

class MailboxConversation extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailbox_conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id'
    ];

    
    /**
     * The user inboxes that the conversation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inboxes() {
        return $this->morphedByMany(MailboxInbox::class, 'container', 'mailbox_conversations_containers');
    }
    
    /**
     * The user trashbins that the conversation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trashbins() {
        return $this->morphedByMany(MailboxTrash::class);
    }
    
    /**
     * The messages that belong to a conversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function messages() {
        return $this->hasMany(MailboxConversationMessage::class, 'conversation_id');
    }
}

