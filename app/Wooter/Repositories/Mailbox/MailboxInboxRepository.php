<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\MailboxInbox;

class MailboxInboxRepository
{

    public function create(MailboxInbox $inbox)
    {
        return $inbox->save();
    }

    public function update(MailboxInbox $inbox)
    {
        return $inbox->save();
    }

    public function getById($inboxId) {
        return MailboxInbox::whereId($inboxId)->first();
    }

    public function getFromIds($inboxIds)
    {
        return MailboxInbox::whereIn('id', $inboxIds)->get();
    }
}

