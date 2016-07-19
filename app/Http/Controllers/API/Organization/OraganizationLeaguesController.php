<?php

namespace Wooter\Http\Controllers\API\Organization;

use Exception;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Organization\ArchiveLeaguesByOrganizationCommand;
use Wooter\Commands\Organization\DeleteLeaguesByOrganizationCommand;
use Wooter\Commands\Organization\ReadLeaguesByOrganizationCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\UserRole;
use Wooter\Wooter\Transformers\Organization\OrganizationLeaguesListArchiveTransformer;
use Wooter\Wooter\Transformers\Organization\OrganizationLeaguesListDeleteTransformer;
use Wooter\Wooter\Transformers\Organization\OrganizationLeaguesListTransformer;

class OraganizationLeaguesController extends ApiController {

    /**
     * @var OrganizationLeaguesListTransformer
     */
    private $TRANSFORMER;

    /**
     * OraganizationLeaguesController constructor.
     *
     * @param OrganizationLeaguesListTransformer        $list
     * @param OrganizationLeaguesListDeleteTransformer  $del
     * @param OrganizationLeaguesListArchiveTransformer $archive
     */
    public function __construct (OrganizationLeaguesListTransformer $list, OrganizationLeaguesListDeleteTransformer $del, OrganizationLeaguesListArchiveTransformer $archive) {
        $this->TRANSFORMER = [
            "list" => $list,
            "delete" => $del,
            "archive" => $archive
        ];

        $this->middleware('jwt.auth');
        // $this->middleware('user.is_organization');
    }

    /**
     * Show leagues list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index (){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            $leagues = $this->dispatchFromArray(ReadLeaguesByOrganizationCommand::class, [ "user" => $user ]);
            
            return $this->respond([
                'data' => $this->TRANSFORMER['list']->transform($leagues)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Delete League
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy ($id) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $response = $this->dispatchFromArray(DeleteLeaguesByOrganizationCommand::class, [ "user" => $user, "id" => $id ]);

            return $this->respond([
                'data' => $this->TRANSFORMER['delete']->transform($response)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Update League (used to archive a league)
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update ($id) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $response = $this->dispatchFromArray(ArchiveLeaguesByOrganizationCommand::class, [ "user" => $user, "id" => $id ]);

            return $this->respond([
                'data' => $this->TRANSFORMER['archive']->transform($response)
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
