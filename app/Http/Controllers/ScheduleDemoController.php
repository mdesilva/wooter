<?php

namespace Wooter\Http\Controllers;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Requests\ScheduleDemoRequest;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\ScheduleDemoCommand;
use Wooter\Commands\ReadScheduleDemoCommand;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Wooter\Transformers\ScheduleDemoTransformer;
use Wooter\Wooter\Transformers\ScheduleDemosTransformer;
use Exception;

class ScheduleDemoController extends Controller
{
               use Responder, ApiDocErrorBlocs;
    public function __construct(ScheduleDemoTransformer $ScheduleDemoTransformer , 
        ScheduleDemosTransformer $ScheduleDemosTransformer){
        $this->ScheduleDemoTransformer = $ScheduleDemoTransformer;
        $this->ScheduleDemosTransformer = $ScheduleDemosTransformer;
    }

    /**
     * @api               {get} scheduledemo Index
     * @apiName           Index
     * @apiGroup          Schedule
     * @apiDescription    Returns an array of schedules
     *
     * @apiSuccess {Array} data Array with all the schedules.
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'id' => 1,
     *                  'name' => $schedule_name,
     *                  'email' => $schedule_email,
     *                  'phpne' => $schedule_phone,
     *                  'comments' => $schedule_comments,
     *                  'created_at' => $schedule_created_at,
     *                  'updated_at' => $schedule_updated_at
     *              ]
     *          ]
     *     }
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $render = $this->dispatch(new ReadScheduleDemoCommand);    
            return $this->respond([
                'data' => $this->ScheduleDemosTransformer->transform($render , true)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @api               {get} scheduledemo Store
     * @apiName           Store
     * @apiGroup          Schedule
     * @apiDescription    Returns the status of the stored schedule
     *
     * @apiSuccess {Array} data containing the status of the stored schedule
     * 
     * @apiParam {string} [name] The name of the schedule
     * @apiParam {string} [email] The email of the schedule
     * @apiParam {string} [phone] The phone number for the schedule
     * @apiParam {string} [comments] Comments regarding the schedule
     *
     * @apiSuccessExample Success
     *     HTTP/1.1 200 OK
     *     {
     *          "data": [
     *              [
     *                  'status' => $schedule_status
     *              ]
     *          ]
     *     }
     *
     * @return JsonResponse
     */
    public function store(ScheduleDemoRequest $request)
    {
        try {
            $render = $this->dispatch(new ScheduleDemoCommand($request));
            $render['status'] = "success";
            $event = $request;
            $event->subject = "Schedule Demo Form Submission";
            \Event::fire('Email.StaticFormSubmission', array($event));
            return $this->respond([
                'data' => $this->ScheduleDemoTransformer->transform($render['status'])
            ]);

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
