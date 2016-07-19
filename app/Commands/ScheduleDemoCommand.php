<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Wooter\Repositories\ScheduleDemoRepository;
use Exception;
use Wooter\ScheduleDemo;
use DB;
use Artisan;

class ScheduleDemoCommand extends Command implements SelfHandling
{
   use DispatchesJobs;


    private $name;

    private $email;

    private $phone;

    private $comments;


/**
     * Create a new command instance.
     *
     * @param $email
     * @param $phone
     * @param $comments
     * @param $name
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
     * @return void
     */
    public function handle(ScheduleDemoRepository $ScheduleDemoRepository)
    {
        $ScheduleDemo = DB::transaction(function () use ($ScheduleDemoRepository) {

            $ScheduleDemo = new ScheduleDemo;
            $ScheduleDemo->name = $this->name;
            $ScheduleDemo->email = $this->email;
            $ScheduleDemo->phone = $this->phone;
            $ScheduleDemo->comments = $this->comments;

            $ScheduleDemoRepository->create($ScheduleDemo);
            $ScheduleDemo->status = "success";
            return $ScheduleDemo;
        });
        return $ScheduleDemo;
    }
}
