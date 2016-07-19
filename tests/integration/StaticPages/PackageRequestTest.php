<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Wooter\LeagueOrganization;
use Illuminate\Support\Facades\Auth;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Organization;
use Wooter\PackageRequest;
use Wooter\Role;
use Wooter\ServiceRequest;
use Wooter\Sport;
use Wooter\User;
use Wooter\Wooter\Contracts\HTTPStatusCode;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\SlugExistsException;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;

class PackageRequestTest extends TestCase
{
    use DatabaseTransactions, MailTest;

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_an_elite_package_with_features()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $packageType = PackageRequest::ELITE_PACKAGE;
        $sport = 'Basketball';
        $numberOfPlayers = $this->faker->numberBetween(2,15);
        $numberOfTeams = $this->faker->numberBetween(2,15);
        $numberOfGamesPerTeam = $this->faker->numberBetween(2,15);
        $fullGameFootage = $this->faker->boolean();
        $gameHighlights = $this->faker->boolean();
        $statistics = $this->faker->boolean();
        $proVideography = $this->faker->boolean();
        $top_10 = $this->faker->boolean();
        $weeklyRecap = $this->faker->boolean();
        $playerPhotos = $this->faker->boolean();
        $teamPhotos = $this->faker->boolean();
        $promoVideo = $this->faker->boolean();
        $mediaCoverage = $this->faker->boolean();
        $blogExposure = $this->faker->boolean();

        $data = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'package_type' => $packageType,
            'sport' => $sport,
            'number_of_players' => $numberOfPlayers,
            'number_of_teams' => $numberOfTeams,
            'number_of_games_per_team' => $numberOfGamesPerTeam,
            'full_game_footage' => $fullGameFootage,
            'game_highlights' => $gameHighlights,
            'statistics' => $statistics,
            'pro_videography' => $proVideography,
            'top_10' => $top_10,
            'weekly_recap' => $weeklyRecap,
            'player_photos' => $playerPhotos,
            'team_photos' => $teamPhotos,
            'promo_video' => $promoVideo,
            'media_coverage' => $mediaCoverage,
            'blog_exposure' => $blogExposure
        ];

        $this->post('api/package-requests', $data);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['package_type'], $packageType);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['sport'], $sport);
        $this->assertEquals($result['data']['number_of_players'], $numberOfPlayers);
        $this->assertEquals($result['data']['number_of_teams'], $numberOfTeams);
        $this->assertEquals($result['data']['full_game_footage'], $fullGameFootage);
        $this->assertEquals($result['data']['game_highlights'], $gameHighlights);
        $this->assertEquals($result['data']['statistics'], $statistics);
        $this->assertEquals($result['data']['pro_videography'], $proVideography);
        $this->assertEquals($result['data']['top_10'], $top_10);
        $this->assertEquals($result['data']['weekly_recap'], $weeklyRecap);
        $this->assertEquals($result['data']['player_photos'], $playerPhotos);
        $this->assertEquals($result['data']['team_photos'], $teamPhotos);
        $this->assertEquals($result['data']['promo_video'], $promoVideo);
        $this->assertEquals($result['data']['media_coverage'], $mediaCoverage);
        $this->assertEquals($result['data']['blog_exposure'], $blogExposure);
    }
    /**
     * A basic test example.
     * @test
     */
    public function it_requests_an_elite_package_without_features()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $packageType = PackageRequest::ELITE_PACKAGE;
        $sport = 'Basketball';
        $numberOfPlayers = $this->faker->numberBetween(2,15);
        $numberOfTeams = $this->faker->numberBetween(2,15);
        $numberOfGamesPerTeam = $this->faker->numberBetween(2,15);

        $data = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'package_type' => $packageType,
            'sport' => $sport,
            'number_of_players' => $numberOfPlayers,
            'number_of_teams' => $numberOfTeams,
            'number_of_games_per_team' => $numberOfGamesPerTeam,
        ];

        $this->post('api/package-requests', $data);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $email);
        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['package_type'], $packageType);
        $this->assertEquals($result['data']['phone'], $phone);
        $this->assertEquals($result['data']['sport'], $sport);
        $this->assertEquals($result['data']['number_of_players'], $numberOfPlayers);
        $this->assertEquals($result['data']['number_of_teams'], $numberOfTeams);
        $this->assertEquals($result['data']['full_game_footage'], false);
        $this->assertEquals($result['data']['game_highlights'], false);
        $this->assertEquals($result['data']['statistics'], false);
        $this->assertEquals($result['data']['pro_videography'], false);
        $this->assertEquals($result['data']['top_10'], false);
        $this->assertEquals($result['data']['weekly_recap'], false);
        $this->assertEquals($result['data']['player_photos'], false);
        $this->assertEquals($result['data']['team_photos'], false);
        $this->assertEquals($result['data']['promo_video'], false);
        $this->assertEquals($result['data']['media_coverage'], false);
        $this->assertEquals($result['data']['blog_exposure'], false);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_package_and_admin_reads_it()
    {
        $admin = $this->createAndLoginAnAdmin();

        $packageRequest = factory(PackageRequest::class)->create();

        $this->get('api/package-requests/' . $packageRequest->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['email'], $packageRequest->email);
        $this->assertEquals($result['data']['name'], $packageRequest->name);
        $this->assertEquals($result['data']['package_type'], $packageRequest->package_type);
        $this->assertEquals($result['data']['phone'], $packageRequest->phone);
        $this->assertEquals($result['data']['sport'], $packageRequest->sport);
        $this->assertEquals($result['data']['number_of_players'], $packageRequest->number_of_players);
        $this->assertEquals($result['data']['number_of_teams'], $packageRequest->number_of_teams);
        $this->assertEquals($result['data']['number_of_games_per_team'], $packageRequest->number_of_games_per_team);
        $this->assertEquals($result['data']['full_game_footage'], $packageRequest->full_game_footage);
        $this->assertEquals($result['data']['game_highlights'], $packageRequest->game_highlights);
        $this->assertEquals($result['data']['statistics'], $packageRequest->statistics);
        $this->assertEquals($result['data']['pro_videography'], $packageRequest->pro_videography);
        $this->assertEquals($result['data']['top_10'], $packageRequest->top_10);
        $this->assertEquals($result['data']['weekly_recap'], $packageRequest->weekly_recap);
        $this->assertEquals($result['data']['player_photos'], $packageRequest->player_photos);
        $this->assertEquals($result['data']['team_photos'], $packageRequest->team_photos);
        $this->assertEquals($result['data']['promo_video'], $packageRequest->promo_video);
        $this->assertEquals($result['data']['media_coverage'], $packageRequest->media_coverage);
        $this->assertEquals($result['data']['blog_exposure'], $packageRequest->blog_exposure);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_requests_a_package_and_admin_deletes_it()
    {
        $admin = $this->createAndLoginAnAdmin();

        $packageRequest = factory(PackageRequest::class)->create();

        $this->delete('api/package-requests/' . $packageRequest->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data'], 'Deleted successfully');

        $this->assertNull($packageRequest->fresh());
    }

    /**
     * A basic test example.
     * @test
     */
    public function admin_reads_all_package_requests()
    {
        $admin = $this->createAndLoginAnAdmin();

        $packageRequestCollection = factory(PackageRequest::class, 5)->create();
        /**
         * @var $packageRequestCollection Collection
         */

        $this->get('api/package-requests/', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $results = json_decode($this->response->content(),true);

        foreach ($results['data'] as $result) {
            $packageRequest = $packageRequestCollection->shift();
            $this->assertEquals($result['email'], $packageRequest->email);
            $this->assertEquals($result['name'], $packageRequest->name);
            $this->assertEquals($result['package_type'], $packageRequest->package_type);
            $this->assertEquals($result['phone'], $packageRequest->phone);
            $this->assertEquals($result['sport'], $packageRequest->sport);
            $this->assertEquals($result['number_of_players'], $packageRequest->number_of_players);
            $this->assertEquals($result['number_of_teams'], $packageRequest->number_of_teams);
            $this->assertEquals($result['number_of_games_per_team'], $packageRequest->number_of_games_per_team);
            $this->assertEquals($result['full_game_footage'], $packageRequest->full_game_footage);
            $this->assertEquals($result['game_highlights'], $packageRequest->game_highlights);
            $this->assertEquals($result['statistics'], $packageRequest->statistics);
            $this->assertEquals($result['pro_videography'], $packageRequest->pro_videography);
            $this->assertEquals($result['top_10'], $packageRequest->top_10);
            $this->assertEquals($result['weekly_recap'], $packageRequest->weekly_recap);
            $this->assertEquals($result['player_photos'], $packageRequest->player_photos);
            $this->assertEquals($result['team_photos'], $packageRequest->team_photos);
            $this->assertEquals($result['promo_video'], $packageRequest->promo_video);
            $this->assertEquals($result['media_coverage'], $packageRequest->media_coverage);
            $this->assertEquals($result['blog_exposure'], $packageRequest->blog_exposure);
        }
    }

    /**
     * A basic test example.
     * @test
     */
    public function normal_reads_all_services_requests_and_gets_forbidden()
    {

    }

    /**
     * A basic test example.
     * @test
     */
    public function normal_reads_a_service_request_and_gets_forbidden()
    {

    }

}
