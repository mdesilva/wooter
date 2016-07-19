<?php

namespace Wooter\Wooter\Repositories\Mailbox;

use DB;
use Wooter\MailboxTrash;

class MailboxTrashRepository
{

    public function create(MailboxTrash $trash)
    {
        return $trash->save();
    }

    public function update(MailboxTrash $trash)
    {
        return $trash->save();
    }

    public function getById($trashId) {
        return MailboxTrash::whereId($trashId)->first();
    }

}

