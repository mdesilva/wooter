<?php

namespace Wooter\Http\Controllers\API\Organization\League;

use Exception;
use Wooter\Commands\Organization\League\ReadLeagueInfoCommand;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Http\Requests;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Transformers\Organization\League\LeagueInfoTransformer;

class LeagueOrganizationsInfoController extends ApiController {

    private $LeagueInfoTransformer;


    function __construct (LeagueInfoTransformer $LeagueInfoTransformer) {

        $this->LeagueInfoTransformer = $LeagueInfoTransformer;

    }

    /**
     * @api               {get} api/leagues/:leagueId/info Read
     * @apiVersion        1.0.0
     * @apiName           Read
     * @apiGroup          League Information
     * @apiPermission     public
     * @apiDescription    Get the league and organization basic informations
     *
     * @apiParam {Number} LeagueId Id of the League
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          {
     *              "data": {
     *              "id": 1,
     *                  "name": " ... ",
     *                  "description": " ... ",
     *                  "organization": {
     *                      "id": 1,
     *                      "name": " ... ",
     *                      "email": " ... ",
     *                      "phone": " ... ",
     *                      "image": " ... ",
     *                      "social": {
     *                          "facebook": " ... ",
     *                          "twitter": " ... ",
     *                          "instagram": " ... ",
     *                          "pinterest": " ... ",
     *                          "google": " ... "
     *                      }
     *                  }
     *              }
     *          }
     *     }
     *
     *
     * @apiUse            LeagueNotFound
     *
     * @param $leagueId
     *
     * @return array
     */
    public function index ($leagueId) {

        try {
            
            $leagueInfo = $this->dispatchFromArray(ReadLeagueInfoCommand::class, ['league_id' => $leagueId]);

            return $this->respond([
                'data' => $this->LeagueInfoTransformer->transform($leagueInfo)
            ]);

        } catch (LeagueNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

    }

}
