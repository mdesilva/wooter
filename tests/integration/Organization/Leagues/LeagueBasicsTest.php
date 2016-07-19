<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;

class LeagueBasicsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_league_basics()
    {
        $this->createLeagueAndItsBasics();
    }
    /**
     *
     * @test
     */
    public function it_creates_a_league_basics_without_logo()
    {
        // 1 Create the world


        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $minAge = $this->faker->numberBetween(14,20);
        $maxAge = $this->faker->numberBetween(21,99);

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $image = prepareFileUpload($imagePath, $imageFileName);
        /**
         * @var UploadedFile $image
         */

        $data = [
            'min_age'=> $minAge,
            'max_age'=> $maxAge,
            'gender'=> 'male',
        ];

        // 2 Test what you want

        $this->call('POST', 'api/leagues/' . $league->id . '/basics', $data, [], [], $this->transformHeadersToServerVars($this->getHeaders()));

        // 3 Make the assertions

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['min_age'], $minAge);
        $this->assertEquals($result['data']['max_age'], $maxAge);
        $this->assertEquals($result['data']['gender'], 'male');

        return $league->id;
    }

    private function createLeagueAndItsBasics()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $minAge = $this->faker->numberBetween(14,20);
        $maxAge = $this->faker->numberBetween(21,99);

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $image = prepareFileUpload($imagePath, $imageFileName);
        /**
         * @var UploadedFile $image
         */

        $data = [
            'min_age'=> $minAge,
            'max_age'=> $maxAge,
            'gender'=> 'male',
        ];

        $this->call('POST', 'api/leagues/' . $league->id . '/basics', $data, [], ['logo' => $image], $this->transformHeadersToServerVars($this->getHeaders()));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['min_age'], $minAge);
        $this->assertEquals($result['data']['max_age'], $maxAge);
        $this->assertEquals($result['data']['gender'], 'male');

        $this->assertEquals($result['data']['logo']['file_name'], $imageFileName);
        $this->assertEquals($result['data']['logo']['size'], $image->getSize());
        $this->assertEquals($result['data']['logo']['mime_type'], $image->getClientMimeType());
        $this->assertEquals($result['data']['logo']['extension'], $image->getExtension());

        $photoPath = config('file.image.visible_path') . 'league_logo_' . $result['data']['logo_id'] . '.' . $image->getExtension();
        $this->assertEquals($photoPath, $result['data']['logo']['file_path']);

        $photoPath = config('file.image.visible_path') . 'league_logo_thumbnail_' . $result['data']['logo_id'] . '.' . $image->getExtension();
        $this->assertEquals($photoPath, $result['data']['logo']['thumbnail_path']);

        return $league->id;
    }

    /**
     * @test
     */
    public function it_edits_the_league_basics()
    {
        $leagueId = $this->createLeagueAndItsBasics();

        $league = LeagueOrganization::whereId($leagueId)->first();
        $this->assertInstanceOf(LeagueBasics::class, $league->basics);

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $image = prepareFileUpload($imagePath, $imageFileName);
        /**
         * @var UploadedFile $image
         */

        $minAge = $this->faker->numberBetween(14,20);
        $maxAge = $this->faker->numberBetween(21,99);

        $data = [
            'min_age'=> $minAge,
            'max_age'=> $maxAge,
            'gender'=> 'male',
        ];
        $this->call('PUT', 'api/leagues/' . $league->id . '/basics', $data, [], ['logo' => $image], $this->transformHeadersToServerVars($this->getHeaders()));

        $this->assertResponseOk();
        $this->isJson();
        $league = $league->fresh();
        $result = json_decode($this->response->content(), true);
        $this->assertEquals($result['data']['min_age'], $minAge);
        $this->assertEquals($result['data']['max_age'], $maxAge);
        $this->assertEquals($league->basics->min_age, $minAge);
        $this->assertEquals($league->basics->max_age, $maxAge);

        $this->assertEquals($result['data']['min_age'], $minAge);
        $this->assertEquals($result['data']['max_age'], $maxAge);

        $this->assertEquals($result['data']['logo']['file_name'], $imageFileName);
        $this->assertEquals($result['data']['logo']['size'], $image->getSize());
        $this->assertEquals($result['data']['logo']['mime_type'], $image->getClientMimeType());
        $this->assertEquals($result['data']['logo']['extension'], $image->getExtension());

        $photoPath = config('file.image.visible_path') . 'league_logo_' . $result['data']['logo_id'] . '.' . $image->getExtension();
        $this->assertEquals($photoPath, $result['data']['logo']['file_path']);

        $photoPath = config('file.image.visible_path') . 'league_logo_thumbnail_' . $result['data']['logo_id'] . '.' . $image->getExtension();
        $this->assertEquals($photoPath, $result['data']['logo']['thumbnail_path']);

    }

    /**
     * @test
     */
    public function it_reads_the_league_basics()
    {
        $leagueId = $this->createLeagueAndItsBasics();

        $league = LeagueOrganization::whereId($leagueId)->first();
        $this->assertInstanceOf(LeagueBasics::class, $league->basics);

        $this->get('api/leagues/' . $league->id . '/basics', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $leagueBasics = json_decode($this->response->content(), true);

        $this->assertEquals($leagueBasics['data']['gender'], $league->basics->gender);
        $this->assertEquals($leagueBasics['data']['min_age'], $league->basics->min_age);
        $this->assertEquals($leagueBasics['data']['max_age'], $league->basics->max_age);
        $this->assertEquals($leagueBasics['data']['league_id'], $league->id);
    }
}
