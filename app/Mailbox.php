<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;
use Wooter\User;
use Wooter\MailboxInbox;
use Wooter\MailboxTrash;
use Wooter\MailboxConversation;
use Wooter\MailboxConversationMessage;
use Carbon\Carbon;
use DB;

class Mailbox extends Model {
    
    private $mailbox;
    
    private $container;
    
    private $conversations;
    
    private $titledConversations;
    
    private $datedConversations;
    
    private $messages;
    
    private $broadcasts;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailboxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'owner_id',
        'owner_type',
        'created_at',
        'updated_at'
    ];
    
    /**
     *
     * @var string
     */
    public $empty = false;

    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owner() {
        
    }
    
    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inbox() {
        return $this->hasOne(MailboxInbox::class);
    }
    
    /**
     * The owner of the mailbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trash() {
        return $this->hasOne(MailboxTrash::class);
    }

    
    public function getMailDates($mail) {
        $dates = [];
        foreach($mail as $item) {
            if (!in_array($item['date'], $dates)) {
                $dates[] = $item['date'];
            }
        }
        
        return $dates;
    }
}

