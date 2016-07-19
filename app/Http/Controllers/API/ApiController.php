<?php

namespace Wooter\Http\Controllers\API;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;
use Wooter\LeagueOrganization;
use Wooter\Wooter\Traits\ApiDocErrorBlocs;
use Wooter\Wooter\Traits\Responder;

abstract class ApiController extends Controller
{

    const DEFAULT_ORDER_BY = 'id';
    const DEFAULT_ORDER_DIRECTION = 'DESC';
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 15;
    const DEFAULT_ORDER_BY_VIDEOS_TYPE = 'Qnap';
    const DEFAULT_GET_VIDEOS_TYPE = 'All';
    const DEFAULT_COMPETITION_TYPE = LeagueOrganization::class;

    use Responder, ApiDocErrorBlocs;
}
