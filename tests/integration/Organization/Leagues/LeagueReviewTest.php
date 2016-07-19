<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\LeagueReview;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Team;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeagueReviewTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_adds_a_review_for_a_league()
    {
        $user = $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create();

        $review = $this->faker->text;
        $stars = $this->faker->numberBetween(1,5);

        $data = [
            'review' => $review,
            'stars' => $stars
        ];

        $this->post('api/leagues/' . $league->id . '/reviews', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['review'], $review);
        $this->assertEquals($result['data']['reviewer']['first_name'], $user->first_name);
        $this->assertEquals($result['data']['reviewer']['picture']['file_path'], $user->picture->file_path);
        $this->assertEquals($result['data']['reviewer_id'], $user->id);
        $this->assertEquals($result['data']['verified'], false);
        $this->assertEquals($result['data']['stars'], $stars);
    }

    /**
     * @test
     */
    public function it_reads_all_league_reviews()
    {
        $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create();
        $leagueReviews = factory(LeagueReview::class, 10)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/reviews?order_direction=asc', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;
        foreach ($leagueReviews as $leagueReview) {
            $this->assertEquals($result['data'][$i]['id'], $leagueReview->id);
            $this->assertEquals($result['data'][$i]['review'], $leagueReview->review);
            $this->assertEquals($result['data'][$i]['reviewer_id'], $leagueReview->reviewer_id);
            $this->assertEquals($result['data'][$i]['verified'], $leagueReview->verified);
            $this->assertEquals($result['data'][$i]['stars'], $leagueReview->stars);
            $i++;
        }

    }
}
