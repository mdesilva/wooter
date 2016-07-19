<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\ContactRepository;
use Exception;
use Wooter\Contact;
use DB;
use Artisan;

class ReadAllContactCommand extends Command implements SelfHandling
{

    use DispatchesJobs;


    /**
     * Create a new command instance.
     *
     * @param $request
     *
     * @internal param $email
     * @internal param $phone
     * @internal param $comments
     * @internal param $name
     */

    public function __construct()
    {
    }

    /**
     * Execute the command.
     *
     * @param ContactRepository $contactRepository
     */
    public function handle(ContactRepository $contactRepository)
    {    
        return $contactRepository->all();
    }
}
