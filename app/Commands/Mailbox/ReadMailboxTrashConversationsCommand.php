<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxConversationsRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxTrashConversationsCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
    
    /*
     * @var
     */
    private $offset;
    
    /*
     * @var
     */
    private $limit;
    
    /*
     * @var 
     */
    private $club_type;
    
    /*
     * @var 
     */
    private $club_id;
    
    /*
     * @var
     */
    private $timeframe;
    
    /*
     * @var
     */
    private $utcOffset;
    
    /*
     * @var
     */
    private $keywords;
    
    /*
     * @var
     */
    private $sent;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $offset, $limit, $club_type, $club_id, $timeframe, $utcOffset, $keywords, $sent)
    {
        $this->userId = $userId;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->club_type = $club_type;
        $this->club_id = $club_id;
        $this->timeframe = $timeframe;
        $this->utcOffset = $utcOffset;
        $this->keywords = $keywords;
        $this->sent = $sent;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           MailboxRepository $mailboxRepository, 
                           MailboxConversationsRepository $conversationsRepository, 
                           LeagueRepository $leagueRepository, 
                           TeamRepository $teamRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        $mailbox       = $mailboxRepository->getByClubTypeAndClubId($this->club_type, $this->club_id, $user->id);
        $conversations = $mailbox->trash->conversations;
        $conversations = $this->keywords ? $conversationsRepository->getByTitle($conversations, $this->keywords) : $conversations;
        $conversations = $this->sent ? $conversationsRepository->getByAuthor($conversations, $this->sent, $user->id) : $conversations;
        $conversations = $conversationsRepository->getByLatestMessagesDate($conversations, $this->timeframe, $this->offset, $this->limit);
        
        return $conversations;
    }
}
