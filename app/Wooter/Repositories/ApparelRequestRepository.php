<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Apparel;

class ApparelRequestRepository
{
	public function all()
	{
		return Apparel::all();
	}
}