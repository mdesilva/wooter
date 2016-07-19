<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Organization;
use Wooter\LeagueOrganization;
use Wooter\LeagueBasics;
use Wooter\LeagueGameVenue;
use Wooter\LeagueVideo;
use Wooter\Video;

class LeagueVideoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_league_video()
    {
        $leagueId = $this->createLeagueAndVideo();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $filePath = $league->videos()->first()->video->file_path;
        $this->delete('api/leagues/' . $league->id . '/videos/' . $league->videos()->first()->video->id, [], $this->getHeaders());
        $this->assertFileNotExists($filePath);
    }

    private function createLeagueAndVideo()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        exec('cp ' . base_path('/public/videos/testvideo.mp4') . ' /tmp/testvideo1.mp4');
        $videoPath = '/tmp/testvideo1.mp4';
        $videoFileName = $this->faker->word;

        $video = prepareFileUpload($videoPath, $videoFileName);
        /**
         * @var UploadedFile $video
         */

        $description = $this->faker->paragraph();

        $data = [
            'description' => $description
        ];

        $this->call('POST', 'api/leagues/' . $league->id . '/videos', $data, [], ['video' => $video], $this->transformHeadersToServerVars($this->headers));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['file_name'], $videoFileName);
        $this->assertEquals($result['data']['size'], $video->getSize());
        $this->assertEquals($result['data']['mime_type'], $video->getClientMimeType());
        $this->assertEquals($result['data']['description'], $description);

        $videoPath = config('file.video.visible_path') . 'league_video_' . $result['data']['video_id'] . '.';
        $this->assertEquals($videoPath, $result['data']['file_path']);

        return $league->id;
    }

    /**
     * @test
     */
    public function it_edits_a_league_video()
    {
        $leagueId = $this->createLeagueAndVideo();

        $league = LeagueOrganization::whereId($leagueId)->first();

        exec('cp ' . base_path('/public/videos/testvideo.mp4') . ' /tmp/testvideo1.mp4');
        $videoPath = '/tmp/testvideo1.mp4';
        $videoFileName = $this->faker->word;

        $video = prepareFileUpload($videoPath, $videoFileName);
        /**
         * @var UploadedFile $video
         */

        $description = $this->faker->paragraph();

        $data = [
            'description' => $description
        ];

        $this->call('POST', 'api/leagues/' . $league->id . '/videos', $data, [], ['video' => $video], $this->transformHeadersToServerVars($this->getHeaders()));

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['file_name'], $videoFileName);
        $this->assertEquals($result['data']['size'], $video->getSize());
        $this->assertEquals($result['data']['mime_type'], $video->getClientMimeType());
        $this->assertEquals($result['data']['description'], $description);

        $videoPath = config('file.video.visible_path') . 'league_video_' . $result['data']['video_id'] . '.';
        $this->assertEquals($videoPath, $result['data']['file_path']);

        $filePath = $league->fresh()->videos()->first()->video->file_path;
        $this->delete('api/leagues/' . $league->id . '/videos/' . $league->fresh()->videos()->first()->video->id, [], $this->getHeaders());
        $this->assertFileNotExists($filePath);

    }

    /**
     * @test
     */
    public function it_deletes_a_league_video()
    {
        $leagueId = $this->createLeagueAndVideo();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $leagueVideo = LeagueVideo::whereLeagueId($league->id)->first();

        $video = $leagueVideo->video;
        $this->assertInstanceOf(Video::class, $video);

        $this->delete('api/leagues/' . $league->id . '/videos/' . $leagueVideo->id, [], $this->headers);

        $this->assertNull($video->fresh());
        $this->assertNull($leagueVideo->fresh());
    }

    /**
     * @test
     */
    public function it_reads_a_league_video()
    {
        $leagueId = $this->createLeagueAndVideo();

        $league = LeagueOrganization::whereId($leagueId)->first();

        $leagueVideo = LeagueVideo::whereLeagueId($league->id)->first();

        $this->get('api/leagues/' . $league->id . '/videos/' . $leagueVideo->id, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['file_name'], $leagueVideo->video->file_name);
        $this->assertEquals($result['data']['size'], $leagueVideo->video->size);
        $this->assertEquals($result['data']['mime_type'], $leagueVideo->video->mime_type);
        $this->assertEquals($result['data']['description'], $leagueVideo->video->description);

        $videoPath = config('file.video.visible_path') . 'league_video_' . $result['data']['video_id'] . '.';
        $this->assertEquals($videoPath, $result['data']['file_path']);

        $filePath = $leagueVideo->fresh()->video->file_path;
        $this->delete('api/leagues/' . $league->id . '/videos/' . $league->videos()->first()->video->id, [], $this->getHeaders());
    }

    /**
     * @test
     */
    public function it_get_all_videos_for_a_league()
    {
        $leagueId = $this->createLeagueAndVideo();

        $league = LeagueOrganization::whereId($leagueId)->first();

        factory(LeagueVideo::class, 3)->create(['league_id' => $league->id]);

        $this->get('api/leagues/' . $league->id . '/videos', $this->headers);

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertCount(4, $result['data']['videos']);
    }
}
