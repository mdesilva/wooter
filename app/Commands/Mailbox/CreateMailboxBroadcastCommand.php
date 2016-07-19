<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxInboxRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\MailboxBroadcast;

class CreateMailboxBroadcastCommand extends Command implements SelfHandling
{
    /*
     * @var
     */
    private $userId;
    
    /*
     * @var
     */
    private $title;
    
    /*
     * @var
     */
    private $message;
    
    /*
     * @var
     */
    private $recipient_ids;
    
    /*
     * @var
     */
    private $recipients_type;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $title, $message, $recipient_ids, $recipients_type)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->recipient_ids = $recipient_ids;
        $this->recipients_type = $recipients_type;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           TeamRepository $teamRepository, 
                           LeagueRepository $leagueRepository,
                           MailboxInboxRepository $inboxRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        switch ($this->recipients_type){
            case 'player':
                $recipients = $userRepository->getFromIds($this->recipient_ids);
                break;
            case 'team':
                $recipients = $teamRepository->getMailRecipientsFromIds($this->recipient_ids);
                break;
            case 'league':
                $recipients = $leagueRepository->getFromIds($this->recipient_ids);
                break;
        }
        
        $inboxIds = [];
        foreach($recipients as $recipient){
            $inboxIds[] = $recipient->mailbox()->inbox->id;
        }
        
        $broadcast = new MailboxBroadcast();
        
        $broadcast->title = $this->title;
        $broadcast->message = $this->message;
        $broadcast->user_id = $this->userId;
        
        if ($broadcast->save()) {
            $authorInboxId = $user->mailbox()
                                  ->inbox
                                  ->id;
            
            if (!in_array($authorInboxId, $inboxIds)) {
                    $user->mailbox()
                         ->inbox
                         ->broadcasts()
                         ->save($broadcast);
            }
            
            $inboxes = $inboxRepository->getFromIds($inboxIds);
                
            foreach($inboxes as $inbox){
                $inbox->broadcasts()->save($broadcast);
            }
                
            return $broadcast;
        
        }
    }
}
