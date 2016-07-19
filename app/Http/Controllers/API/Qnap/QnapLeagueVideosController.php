<?php

namespace Wooter\Http\Controllers\API\Qnap;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Commands\Qnap\ReadQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\ReadQnapOrganizationLeagueCommand;
use Wooter\Commands\Qnap\CreateQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\UpdateQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\DeleteQnapLeagueVideoCommand;
use Wooter\Wooter\Transformers\Qnap\QnapLeagueVideoTransformer;
use Wooter\Wooter\Transformers\Qnap\QnapOrganizationLeagueTransformer;

class QnapLeagueVideosController extends ApiController
{
    /**
     * @var
     */
    private $qnapLeagueVideoTransformer;

    /**
     * @var
     */
    private $qnapOrganizationLeagueTransformer;

    /**
     * @param QnapLeagueVideoTransformer        $qnapLeagueVideoTransformer
     * @param QnapOrganizationLeagueTransformer $qnapOrganizationLeagueTransformer
     */
    public function __construct(QnapLeagueVideoTransformer $qnapLeagueVideoTransformer, QnapOrganizationLeagueTransformer $qnapOrganizationLeagueTransformer) {

        $this->qnapLeagueVideoTransformer = $qnapLeagueVideoTransformer;
        $this->qnapOrganizationLeagueTransformer = $qnapOrganizationLeagueTransformer;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $qnapVideos = $this->dispatchFromArray(ReadQnapLeagueVideoCommand::class, []);

        return $this->respond([
            'data' => $this->qnapLeagueVideoTransformer->transform($qnapVideos)
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $video = $this->dispatchFrom(CreateQnapLeagueVideoCommand::class, $request);
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
    public function update(Request $request)
    {

        $video = $this->dispatchFrom(UpdateQnapLeagueVideoCommand::class, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $video = $this->dispatchFrom(DeleteQnapLeagueVideoCommand::class, $request);
    }

    /**
     * Prepare list of organizations active leagues
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function organizationLeagues(Request $request)
    {

        $qnapLeagues = $this->dispatchFrom(ReadQnapOrganizationLeagueCommand::class, $request);

        return $this->respond([
            'data' => $this->qnapOrganizationLeagueTransformer->transform($qnapLeagues)
        ]);
    }
}
