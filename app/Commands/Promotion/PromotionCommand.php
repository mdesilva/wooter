<?php

namespace Wooter\Commands\Promotion;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\Command;
use Wooter\LeagueOrganization;

class PromotionCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(League $league)
    {
        $this->league = $league;
    }
    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
    /**
     * [preview_gallery function to create html for preview images]
     * @param  [array] $images [array of photos from promotion_gallery db]
     * @return string         [returns html for preview images]
     */
    public function previewGallery($images)
    {

        $render = '';
        if (count($images) > 0) {

            $count = count($images) - 3;
            $more = '<div class="more"><p><span class="hidden-xs">See more (@ct)</span><span class="visible-xs">(@ct+)</span></p></div>';

            $li = '<li><div class="image lazy-image"><img onerror="this.setAttribute(\'src\', \'/img/promotion/broken-image-league.jpg\')" src="@image" class="gallery-open" data-index="1" onload="resizeImage(this)" alt="">@more</div></li>';

            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];

                if (isset($image)) {
                    $lit = implode($image->src, explode('@image', $li));
                    $lit = implode(($i == 2) ? implode($count, explode('@ct', $more)) : '', explode('@more', $lit));
                    $render .= $lit;
                }
                if ($i >= 2) {

                    break;
                }
            }
        }
        return $render;
    }

    public function renderVideosList($v)
    {

        $v = (array) $v;
        $render = '';
        foreach ($v as $key => $video) {

            $video = (array) $video;

            $thumb = ($video['thumbnail']) ? "data-thumb=\"" . $video['thumbnail'] . "\"" : 'data-thumb="/img/promotion/broken-image-league.jpg"';

            $render .= '<div class="item"><a href="#" class="video-link" ' . $thumb . ' data-video="' . $video['video'] . '"></a></div>';
        }

        return $render;
    }

    /**
     * [starRating description]
     * @param  [int] $rating [re]
     * @return [array]         [array for the rating to loop for stars]
     */
    public function starRating($rating)
    {
        return range(1, $rating);
    }
    /**
     * [isLeageActive description]
     * @param  [date]  $end_date [the end date for the league]
     * @return boolean           [returns true if league end date is less than the current time]
     */
    public function isLeagueActive($end_date)
    {
        $date_before = $end_date;
        // if time greater than now
        if (strtotime("now") < strtotime($date_before)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [promotionPricing this is used for the view to determine if to show you the type of price or not]
     * @param  [array] $array [array of promotion prices]
     * @return [array]        [returns array of if to hide the view or not]
     */
    public function promotionPricing($array)
    {
        $free = 'hide';
        $new = 'hide';
        $returning = 'hide';
        foreach ($array as $price) {
            if ($price->type == 'free' || $price->type == 'free-jersey') {
                $free = '';
            }

            if ($price->type == 'new' || $price->type == 'new-jersey') {
                $new = '';
            }

            if ($price->type == 'returning' || $price->type == 'returning-jersey') {
                $returning = '';
            }

        }
        $data = [
            'free' => $free,
            'new' => $new,
            'returning' => $returning,
        ];
        return $data;
    }
}
