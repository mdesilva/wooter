<?php

namespace Wooter\Http\Controllers\API\Stage\Regular;

use Exception;
use Illuminate\Support\Facades\Request;
use Wooter\Commands\Stage\Regular\CreateRegularCompetitionWeekCommand;
use Wooter\Commands\Stage\Regular\DeleteRegularCompetitionWeekCommand;
use Wooter\Commands\Stage\Regular\ReadRegularCompetitionWeeksCommand;
use Wooter\Http\Controllers\API\ApiController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Http\Requests\Regular\Stage\CreateRegularCompetitionWeekRequest;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularCompetitionWeekNotFound;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Transformers\Stage\Regular\RegularCompetitionWeeksTransformer;

class RegularCompetitionWeeksController extends ApiController
{
    /**
     * @var RegularCompetitionWeeksTransformer
     */
    private $regularCompetitionWeeksTransformer;


    /**
     * @param RegularCompetitionWeeksTransformer $regularCompetitionWeeksTransformer
     */
    public function __construct(RegularCompetitionWeeksTransformer $regularCompetitionWeeksTransformer) {

        $this->regularCompetitionWeeksTransformer = $regularCompetitionWeeksTransformer;

        $this->middleware('jwt.auth');

        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);

    }

    /**
     * Display a listing of the resource.
     *
     * @param $regularId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($regularId)
    {   
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $competitionWeeks = $this->dispatchFromArray(ReadRegularCompetitionWeeksCommand::class, ['userId' => $user->id, 'regular_id' => $regularId]);

            return $this->respond([
                'data' => $this->regularCompetitionWeeksTransformer->transformCollection($competitionWeeks)
            ]);
            
        } catch (RegularStageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRegularCompetitionWeekRequest $request
     * @param                                     $regularId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRegularCompetitionWeekRequest $request, $regularId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $competitionWeek = $this->dispatchFrom(CreateRegularCompetitionWeekCommand::class, $request, ['user_id' => $user->id, 'regular_id' => $regularId]);

            return $this->respond([
                'data' => $this->regularCompetitionWeeksTransformer->transform($competitionWeek)
            ]);

        } catch (RegularStageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());
            
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
     * @param $regularId
     * @param $competitionWeekId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($regularId, $competitionWeekId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteRegularCompetitionWeekCommand::class, ['user_id' => $user->id, 'regular_id' => $regularId, 'competition_week_id' => $competitionWeekId]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch (RegularStageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (RegularCompetitionWeekNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
