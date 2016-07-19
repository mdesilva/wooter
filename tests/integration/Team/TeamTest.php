<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Sport;
use Wooter\Team;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_team_basic()
    {
        $this->createAndLoginAnOrganization();

        $name = $this->faker->name;
        $description = $this->faker->paragraph();

        $sport = Sport::first();

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $coverPhoto = prepareFileUpload($imagePath, $imageFileName);

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto2.png');
        $imagePath = '/tmp/testphoto2.png';

        $imageFileName = $this->faker->name . '.png';

        $logo = prepareFileUpload($imagePath, $imageFileName);

        /**
         * @var UploadedFile $coverPhoto
         * @var UploadedFile $logo
         */
        $data = [
            'name' => $name,
            'sport_id' => $sport->id,
            'description' => $description,
        ];

        $this->call('POST', 'api/teams', $data, [], ['cover_photo' => $coverPhoto, 'logo' => $logo], $this->transformHeadersToServerVars($this->headers));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['description'], $description);

        $this->assertEquals($result['data']['cover_photo']['file_name'], $coverPhoto->getClientOriginalName());
        $this->assertEquals($result['data']['cover_photo']['size'], $coverPhoto->getClientSize());
        $this->assertEquals($result['data']['cover_photo']['mime_type'], $coverPhoto->getClientMimeType());
        $this->assertEquals($result['data']['cover_photo']['extension'], $coverPhoto->getExtension());
        $this->assertEquals($result['data']['cover_photo']['description'], Team::COVER_PHOTO_DESCRIPTION);

        $this->assertEquals($result['data']['logo']['file_name'], $logo->getClientOriginalName());
        $this->assertEquals($result['data']['logo']['size'], $logo->getClientSize());
        $this->assertEquals($result['data']['logo']['mime_type'], $logo->getClientMimeType());
        $this->assertEquals($result['data']['logo']['extension'], $logo->getExtension());
        $this->assertEquals($result['data']['logo']['description'], Team::LOGO_DESCRIPTION);

        $this->assertEquals($result['data']['sport']['name'], $sport->name);
        $this->assertEquals($result['data']['sport']['id'], $sport->id);
    }

    /**
     * @test
     */
    public function it_edits_a_basic_team()
    {
        $user = $this->createAndLoginAnOrganization();

        $team = factory(Team::class)->create();

        $name = $this->faker->name;
        $description = $this->faker->paragraph();

        $sport = Sport::first();

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto.png');
        $imagePath = '/tmp/testphoto.png';

        $imageFileName = $this->faker->name . '.png';

        $coverPhoto = prepareFileUpload($imagePath, $imageFileName);

        exec('cp '.$this->testPhotoPath .' /tmp/testphoto2.png');
        $imagePath = '/tmp/testphoto2.png';

        $imageFileName = $this->faker->name . '.png';

        $logo = prepareFileUpload($imagePath, $imageFileName);
        /**
         * @var UploadedFile $coverPhoto
         * @var UploadedFile $logo
         */

        $data = [
            'name' => $name,
            'sport_id' => $sport->id,
            'description' => $description,
        ];

        $this->call('PUT', 'api/teams/' . $team->id, $data, [], ['cover_photo' => $coverPhoto, 'logo' => $logo], $this->transformHeadersToServerVars($this->headers));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], $name);
        $this->assertEquals($result['data']['description'], $description);

        $this->assertEquals($result['data']['cover_photo']['size'], $coverPhoto->getClientSize());
        $this->assertEquals($result['data']['cover_photo']['file_name'], $coverPhoto->getClientOriginalName());
        $this->assertEquals($result['data']['cover_photo']['mime_type'], $coverPhoto->getClientMimeType());
        $this->assertEquals($result['data']['cover_photo']['extension'], $coverPhoto->getExtension());
        $this->assertEquals($result['data']['cover_photo']['description'], Team::COVER_PHOTO_DESCRIPTION);

        $this->assertEquals($result['data']['logo']['file_name'], $logo->getClientOriginalName());
        $this->assertEquals($result['data']['logo']['size'], $logo->getClientSize());
        $this->assertEquals($result['data']['logo']['mime_type'], $logo->getClientMimeType());
        $this->assertEquals($result['data']['logo']['extension'], $logo->getExtension());
        $this->assertEquals($result['data']['logo']['description'], Team::LOGO_DESCRIPTION);

        $this->assertEquals($result['data']['sport']['name'], $sport->name);
        $this->assertEquals($result['data']['sport']['id'], $sport->id);
    }

    /**
     * @test
     */
    public function it_deletes_a_team()
    {
        $user = $this->createAndLoginAnOrganization();

        $team = factory(Team::class)->create();

        $this->delete('api/teams/' . $team->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data'], 'Deleted successfully');
        $this->assertNull($team->fresh());
    }

    /**
     * @test
     */
    public function it_reads_a_team()
    {
        $this->createAndLoginABasicUser();

        $team = factory(Team::class)->create();

        $this->get('api/teams/' . $team->id, $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $this->assertEquals($result['data']['name'], $team->name);
        $this->assertEquals($result['data']['description'], $team->description);

        $this->assertEquals($result['data']['cover_photo']['file_name'], $team->cover_photo->file_name);
        $this->assertEquals($result['data']['cover_photo']['size'], $team->cover_photo->size);
        $this->assertEquals($result['data']['cover_photo']['mime_type'], $team->cover_photo->mime_type);
        $this->assertEquals($result['data']['cover_photo']['extension'], $team->cover_photo->extension);
        $this->assertEquals($result['data']['cover_photo']['description'], Team::COVER_PHOTO_DESCRIPTION);

        $this->assertEquals($result['data']['logo']['file_name'], $team->logo->file_name);
        $this->assertEquals($result['data']['logo']['size'], $team->logo->size);
        $this->assertEquals($result['data']['logo']['mime_type'], $team->logo->mime_type);
        $this->assertEquals($result['data']['logo']['extension'], $team->logo->extension);
        $this->assertEquals($result['data']['logo']['description'], Team::LOGO_DESCRIPTION);

        $this->assertEquals($result['data']['sport']['name'], $team->sport->name);
        $this->assertEquals($result['data']['sport']['id'], $team->sport->id);
    }
}
