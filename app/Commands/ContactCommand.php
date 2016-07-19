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

class ContactCommand extends Command implements SelfHandling
{

    use DispatchesJobs;


    private $name;

    private $email;

    private $phone;

    private $comments;


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

    public function __construct($request)
    {
        $this->name = $request->name;
        $this->email = $request->email;
        $this->phone = $request->phone;
        $this->comments = $request->comments;
    }

    /**
     * Execute the command.
     *
     * @param ContactRepository $contactRepository
     */
    public function handle(ContactRepository $contactRepository)
    {
         $contact = DB::transaction(function () use ($contactRepository) {

            $contact = new Contact;
            $contact->name = $this->name;
            $contact->email = $this->email;
            $contact->phone = $this->phone;
            $contact->comments = $this->comments;

            $contactRepository->create($contact);

            return $contact;
        });
        
        return $contact;
    }
}
