<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Image;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;
use Wooter\LeaguePhoto;

class LeaguePhotoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_league_photo()
    {
        $leagueId = $this->registerCreateLeagueAndPhoto();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $filePath = $league->photos()->first()->photo->file_path;
        $this->delete('api/leagues/' . $league . '/photos/' . $league->photos()->first()->id, [], $this->headers);
        $this->assertFileNotExists($filePath);
    }

    private function registerCreateLeagueAndPhoto()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $image = prepareFileUpload($imagePath, $imageFileName);
        /**
         * @var UploadedFile $image
         */

        $description = $this->faker->paragraph();

        $data = [
            'league_id' => $league->id,
            'description' => $description
        ];

        $this->call('POST', 'api/leagues/' . $league . '/photos', $data, [], ['photo' => $image], $this->transformHeadersToServerVars($this->getHeaders()));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['file_name'], $imageFileName);
        $this->assertEquals($result['data']['size'], $image->getSize());
        $this->assertEquals($result['data']['mime_type'], $image->getClientMimeType());
        $this->assertEquals($result['data']['extension'], $image->getExtension());
        $this->assertEquals($result['data']['description'], $description);

        return $league->id;
    }

    /**
     * @test
     */
    public function it_deletes_a_league_photo()
    {
        $leagueId = $this->registerCreateLeagueAndPhoto();

        $leaguePhoto = LeaguePhoto::whereLeagueId($leagueId)->first();
        $photo = $leaguePhoto->photo;
        $this->assertInstanceOf(Image::class, $photo);

        $this->delete('api/leagues/' . $leagueId . '/photos/' . $photo->id, [], $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Success');
        $this->assertNull($photo->fresh());
        $this->assertNull($leaguePhoto->fresh());
        $this->assertFileNotExists($photo->file_path);
    }

    /**
     * @test
     */
    public function it_reads_a_league_photo()
    {
        $leagueId = $this->registerCreateLeagueAndPhoto();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $this->get('api/leagues/' . $league->id . '/photos/' . $league->photos->first()->id, $this->headers);

        $image = $league->photos()->first()->photo;

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['file_name'], $image->file_name);
        $this->assertEquals($result['data']['size'], $image->size);
        $this->assertEquals($result['data']['mime_type'], $image->mime_type);
        $this->assertEquals($result['data']['extension'], $image->extension);
        $this->assertEquals($result['data']['description'], $image->description);

        $photoPath =  config('file.image.visible_path') . 'league_photo_' . $result['data']['image_id'] . '.' . $image->extension;
        $this->assertEquals($photoPath, $result['data']['file_path']);

        $photoPath = config('file.image.visible_path') . 'league_photo_thumbnail_' . $result['data']['image_id'] . '.' . $image->extension;
        $this->assertEquals($photoPath, $result['data']['thumbnail_path']);

        $this->delete('api/leagues/' . $league->id . '/photos/' . $league->photos->first()->id, [], $this->getHeaders());
    }

    /**
     * @test
     */
    public function it_get_all_photos_for_a_league()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();
        $league = LeagueOrganization::first();
        $leaguePhotos = factory(LeaguePhoto::class, 3)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/photos', $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertCount(3, $result['data']['photos']);
    }
}
