<?php

namespace Wooter\Commands\Mailbox;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Mailbox\MailboxBroadcastsRepository;
use Wooter\Wooter\Repositories\Mailbox\MailboxRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadMailboxTrashBroadcastsCommand extends Command implements SelfHandling
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
                           MailboxBroadcastsRepository $broadcastsRepository, 
                           LeagueRepository $leagueRepository, 
                           TeamRepository $teamRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
        
        $mailbox    = $mailboxRepository->getByClubTypeAndClubId($this->club_type, $this->club_id, $user->id);
        $broadcasts = $mailbox->trash->broadcasts;
        $broadcasts = $this->keywords ? $broadcastsRepository->getByTitle($broadcasts, $this->keywords) : $broadcasts;
        $broadcasts = $this->sent ? $broadcastsRepository->getByAuthor($broadcasts, $this->sent, $user->id) : $broadcasts;
        $broadcasts = $broadcastsRepository->getByDate($broadcasts, $this->timeframe, $this->offset, $this->limit);
        
        return $broadcasts;
    }
}
