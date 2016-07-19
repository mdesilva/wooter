<?php

namespace Wooter\Wooter\Repositories;

use Wooter\ScheduleDemo;

class ScheduleDemoRepository
{
	public function create(ScheduleDemo $scheduledemo)
	{
		$scheduledemo->save();
	}
	public function all()
	{
		return ScheduleDemo::all();
	}
}