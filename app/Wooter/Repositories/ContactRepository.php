<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Contact;

class ContactRepository
{
	public function create(Contact $contact)
	{
		$contact->save();
	}
	public function all()
	{
		return Contact::all();
	}
}