<?php

namespace Wooter\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Requests\ContactRequest;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\ContactCommand;
use Wooter\Commands\ReadAllContactCommand;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Wooter\Transformers\ContactTransformer;
use Wooter\Wooter\Transformers\ReadAllContactTransformer;
use Wooter\Events\Email\StaticFormSubmissionEvent;
use Exception;


class ContactController extends Controller
{
           use Responder, ApiDocErrorBlocs;


    public function __construct(ContactTransformer $contactTransformer, ReadAllContactTransformer $readAllContactTransformer){
        $this->ContactTransformer = $contactTransformer;
        $this->readAllContactTransformer = $readAllContactTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $render = $this->dispatch(new ReadAllContactCommand);    
            return $this->respond([
                'data' => $this->readAllContactTransformer->transform($render)
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
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        try {
            $render = $this->dispatch(new ContactCommand($request));
            $render['status'] = "success";

            $event = $request;
            $event->subject = "Contact Form Submission";
            \Event::fire(new StaticFormSubmissionEvent($event));
            
            return $this->respond([
                'data' => $this->ContactTransformer->transform($render['status'])
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
