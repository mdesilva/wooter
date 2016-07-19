<?php

namespace Wooter\Http\Controllers\StaticPages;

use Wooter\Commands\Promotion\PromotionCommand;
use Wooter\Http\Controllers\Controller;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * [index this is the index for promotion page example route wooter.co/promotion/{$id} ]
     * @param  int $id [promotion id]
     * @return string     [laravel html template ]
     */
    public function index($id, PromotionCommand $promotionCommand)
    {
        // data array for landing page
        $data = [
            'title' => 'Join league ', // title for the static page,
            'desc' => 'My Promo About', // description of the static page
            'js' => ['/js/landing/promotion/index.js'], // js for the static page
            'css' => ['/css/landing/promotion/promotion.css'], // css needed for the static page
            'data' => [], // league data needed to render page
        ];
        // return view
        return view('landing.promotion.index', $data);
    }
}
