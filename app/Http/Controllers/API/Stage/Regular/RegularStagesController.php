<?php

namespace Wooter\Http\Controllers\API\Stage\Regular;

use Illuminate\Http\Request;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;
use Wooter\Http\Controllers\Controller;
use Wooter\Commands\Stage\Regular\CreateRegularStageCommand;
use Wooter\Wooter\Transformers\Stage\Regular\RegularStagesTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegularStagesController extends Controller
{
    use Responder, ApiDocErrorBlocs;
    
    private $regularStagesTransformer;
    
    public function __construct(RegularStagesTransformer $regularStagesTransformer)
    {
        $this->regularStagesTransformer = $regularStagesTransformer;
        
        $this->middleware('jwt.auth', ['except' => [
            'index',
            'show',
        ]]);
        $this->middleware('user.is_organization', ['except' => [
            'index',
            'show',
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = JWTAuth::parseToken()->authenticate();
        
        try {
            $requestParams = [
                'user_id' => $user->id,
                'competition_id' => $request->input('competition_id'),
                'competition_type' => $request->input('competition_type'),
                'rule_id' => $request->input('rule_id'),
                'rule_type' => $request->input('rule_type'),
                'starts_at' => $request->input('starts_at'),
                'ends_at' => $request->input('ends_at')
            ];
            
            $stage = $this->dispatchFromArray(CreateRegularStageCommand::class, $requestParams);
            
            return $this->respond([
                'data' => $this->regularStagesTransformer->transform($stage)
            ]);
        } catch (Exception $ex) {
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
