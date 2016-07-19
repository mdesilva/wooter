<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\City;
use Wooter\Feature;
use Wooter\GameStructure;
use Wooter\GameVenue;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Image;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;
use Wooter\LeaguePermission;
use Wooter\LeaguePhoto;
use Wooter\LeagueVideo;
use Wooter\Like;
use Wooter\PlayerLeague;
use Wooter\Video;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_likes_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $data = [
            'like' => true,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], true);

    }

    /**
     * @test
     */
    public function it_likes_a_video()
    {
        $user = $this->createAndLoginABasicUser();

        $leagueVideo = factory(LeagueVideo::class)->create();

        $data = [
            'like' => true,
            'liked_item_type' => Video::class,
        ];

        $this->post('api/likes/' . $leagueVideo->video->id . '?type=' . Video::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['video']['id'], $leagueVideo->video->id);
        $this->assertSame($result['data']['video']['description'], $leagueVideo->video->description);
        $this->assertSame($result['data']['video']['file_path'], $leagueVideo->video->file_path);
        $this->assertSame($result['data']['video']['size'], $leagueVideo->video->size);
        $this->assertSame($result['data']['video']['file_name'], $leagueVideo->video->file_name);
        $this->assertSame($result['data']['liked'], true);

    }

    /**
     * @test
     */
    public function it_unlikes_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $data = [
            'like' => true,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], true);

        $data = [
            'like' => false,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], false);

    }

    /**
     * @test
     */
    public function it_likes_a_photo_restricted_and_is_refused()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        factory(LeaguePermission::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'type' => LeaguePermission::TYPE_LIKE,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        $data = [
            'like' => true,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->seeStatusCode(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['error']['message'], 'User is not a member of the league, can not perform this action. Must be member.');
    }

    /**
     * @test
     */
    public function it_likes_a_photo_restricted_and_im_member_and_is_ok_and_then_unlikes_it()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        factory(LeaguePermission::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'type' => LeaguePermission::TYPE_LIKE,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        factory(PlayerLeague::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'player_id' => $user->id,
        ]);

        $data = [
            'like' => true,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], true);

        $data = [
            'like' => false,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], false);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], false);
    }


    /**
     * @test
     */
    public function it_likes_a_video_restricted_and_im_member_and_is_ok_and_then_unlikes_it()
    {
        $user = $this->createAndLoginABasicUser();

        $leagueVideo = factory(LeagueVideo::class)->create();

        factory(LeaguePermission::class)->create([
            'league_id' => $leagueVideo->league->id,
            'type' => LeaguePermission::TYPE_LIKE,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        factory(PlayerLeague::class)->create([
            'league_id' => $leagueVideo->league->id,
            'player_id' => $user->id,
        ]);

        $data = [
            'like' => true,
            'liked_item_type' => Video::class,
        ];

        $this->post('api/likes/' . $leagueVideo->video->id . '?type=' . Video::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['video']['id'], $leagueVideo->video->id);
        $this->assertSame($result['data']['video']['description'], $leagueVideo->video->description);
        $this->assertSame($result['data']['video']['file_path'], $leagueVideo->video->file_path);
        $this->assertSame($result['data']['video']['size'], $leagueVideo->video->size);
        $this->assertSame($result['data']['video']['file_name'], $leagueVideo->video->file_name);
        $this->assertSame($result['data']['liked'], true);

        $data = [
            'like' => false,
            'liked_item_type' => Video::class,
        ];

        $this->post('api/likes/' . $leagueVideo->video->id . '?type=' . Video::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['video']['id'], $leagueVideo->video->id);
        $this->assertSame($result['data']['video']['description'], $leagueVideo->video->description);
        $this->assertSame($result['data']['video']['file_path'], $leagueVideo->video->file_path);
        $this->assertSame($result['data']['video']['size'], $leagueVideo->video->size);
        $this->assertSame($result['data']['video']['file_name'], $leagueVideo->video->file_name);
        $this->assertSame($result['data']['liked'], false);

        $this->get('api/likes/' . $leagueVideo->video->id . '?type=' . Video::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], false);
    }

    /**
     * @test
     */
    public function it_reads_a_photo_like_by_me()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $like = factory(Like::class)->create([
            'user_id' => $user->id,
            'liked_item_id' => $leaguePhoto->photo->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], true);
    }

    /**
     * @test
     */
    public function it_reads_a_video_liked_by_me()
    {
        $user = $this->createAndLoginABasicUser();

        $leagueVideo = factory(LeagueVideo::class)->create();

        $like = factory(Like::class)->create([
            'user_id' => $user->id,
            'liked_item_id' => $leagueVideo->video->id,
            'liked_item_type' => Video::class,
        ]);

        $this->get('api/likes/' . $leagueVideo->video->id . '?type=' . Video::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], true);
    }

    /**
     * @test
     */
    public function it_reads_a_photo_unliked_by_me_and_gets_false()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], false);
    }

    /**
     * @test
     */
    public function it_reads_the_total_photo_count_likes()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $like =factory(Like::class, 30)->create([
            'liked_item_id' => $leaguePhoto->photo->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&total_count=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['count'], 30);
    }

    /**
     * @test
     */
    public function it_reads_the_total_video_count_likes()
    {
        $user = $this->createAndLoginABasicUser();

        $leagueVideo = factory(LeagueVideo::class)->create();

        $like =factory(Like::class, 30)->create([
            'liked_item_id' => $leagueVideo->video->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leagueVideo->video->id . '?type=' . Image::class . '&total_count=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['count'], 30);
    }

    /**
     * @test
     */
    public function it_reads_all_people_who_like_the_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $likes =factory(Like::class, 20)->create([
            'liked_item_id' => $leaguePhoto->photo->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach ($likes as $like) {

            if ($i < (ApiController::DEFAULT_LIMIT-1)) {
                $this->assertSame($result['data'][$i]['user']['first_name'], $like->user->first_name);
                $this->assertSame($result['data'][$i]['user']['last_name'], $like->user->last_name);
                $this->assertSame($result['data'][$i]['user']['gender'], $like->user->gender);
                $this->assertSame($result['data'][$i]['user']['id'], $like->user->id);
            }
            $i++;
        }

        $this->assertCount(ApiController::DEFAULT_LIMIT, $result['data']);
    }

    /**
     * @test
     */
    public function it_reads_all_people_who_like_the_photo_paginated()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $likes =factory(Like::class, 26)->create([
            'liked_item_id' => $leaguePhoto->photo->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&offset=16&limit=5', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach ($likes as $like) {

            if ($i > 15 && $i < 20) {
                $this->assertSame($result['data'][$i-16]['user']['first_name'], $like->user->first_name);
                $this->assertSame($result['data'][$i-16]['user']['last_name'], $like->user->last_name);
                $this->assertSame($result['data'][$i-16]['user']['gender'], $like->user->gender);
                $this->assertSame($result['data'][$i-16]['user']['id'], $like->user->id);
            }
            $i++;
        }

        $this->assertCount(5, $result['data']);
    }

    /**
     * @test
     */
    public function it_reads_all_people_who_like_the_video_paginated()
    {
        $user = $this->createAndLoginABasicUser();

        $leagueVideo = factory(LeagueVideo::class)->create();

        $likes =factory(Like::class, 26)->create([
            'liked_item_id' => $leagueVideo->video->id,
            'liked_item_type' => Image::class,
        ]);

        $this->get('api/likes/' . $leagueVideo->video->id . '?type=' . Image::class . '&offset=16&limit=5', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach ($likes as $like) {

            if ($i > 15 && $i < 20) {
                $this->assertSame($result['data'][$i-16]['user']['first_name'], $like->user->first_name);
                $this->assertSame($result['data'][$i-16]['user']['last_name'], $like->user->last_name);
                $this->assertSame($result['data'][$i-16]['user']['gender'], $like->user->gender);
                $this->assertSame($result['data'][$i-16]['user']['id'], $like->user->id);
            }
            $i++;
        }

        $this->assertCount(5, $result['data']);
    }

    /**
     * @test
     */
    public function it_likes_a_restricted_photo_as_league_owner_and_can_do_it()
    {
        $user = $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create([
            'user_id' => $user->id
        ]);

        $leaguePhoto = factory(LeaguePhoto::class)->create([
            'league_id' => $league->id
        ]);

        factory(LeaguePermission::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'type' => LeaguePermission::TYPE_LIKE,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        $data = [
            'like' => true,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], true);

        $data = [
            'like' => false,
            'liked_item_type' => Image::class,
        ];

        $this->post('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $leaguePhoto->photo->id);
        $this->assertSame($result['data']['image']['description'], $leaguePhoto->photo->description);
        $this->assertSame($result['data']['image']['file_path'], $leaguePhoto->photo->file_path);
        $this->assertSame($result['data']['image']['size'], $leaguePhoto->photo->size);
        $this->assertSame($result['data']['image']['file_name'], $leaguePhoto->photo->file_name);
        $this->assertSame($result['data']['liked'], false);

        $this->get('api/likes/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&by_me=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['liked'], false);
    }
}