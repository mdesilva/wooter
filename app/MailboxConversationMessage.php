<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\MailboxConversation; 

class MailboxConversationMessage extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailbox_conversations_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'message'
    ];
    
    /**
     * The conversation that a message belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation() 
    {
        return $this->belongsTo(MailboxConversation::class, 'conversation_id');
    }
    
    public function preview()
    {
        $message = $this->message;
        if (strlen($message) > 35){
            $message = substr($message, 0, 35) . '...';
        }
        
        return $message;
    }
    
    public function date()
    {
        return substr($this->created_at, 0, -9);
    }
    
    public function datetime() 
    {
        ob_start();
        echo $this->created_at;
        return ob_get_clean();
    }
}

