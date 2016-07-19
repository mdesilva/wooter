<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\MailboxInbox;
use Wooter\MailboxTrash;

class MailboxBroadcast extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailbox_broadcasts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'message',
        'user_id'
    ];

    
    /**
     * The user inboxes that the conversation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inboxes() {
        return $this->morphedByMany(MailboxInbox::class);
    }
    
    /**
     * The user trashbins that the conversation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trashbins() {
        return $this->morphedByMany(MailboxTrash::class);
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

