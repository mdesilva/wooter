<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\City;
use Wooter\Comment;
use Wooter\Feature;
use Wooter\GameStructure;
use Wooter\GameVenue;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Image;
use Wooter\LeagueOrganization;
use Wooter\LeagueGameVenue;
use Wooter\LeaguePermission;
use Wooter\LeaguePhoto;
use Wooter\PlayerLeague;
use Wooter\User;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class CommentsTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * @test
     */
    public function it_comments_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comment = $this->faker->paragraph;

        $data = [
            'comment' => $comment,
            'commented_item_type' => Image::class,
        ];

        $this->post('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

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
        $this->assertSame($result['data']['comment'], $comment);

    }

    /**
     * @test
     */
    public function it_edits_a_comment_on_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $comment = factory(Comment::class)->create([
            'user_id' => $user->id
        ]);

        $newComment = $this->faker->paragraph;

        $data = [
            'comment' => $newComment,
        ];

        $this->put('api/comments/' . $comment->id, $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['user']['first_name'], $user->first_name);
        $this->assertSame($result['data']['user']['last_name'], $user->last_name);
        $this->assertSame($result['data']['user']['gender'], $user->gender);
        $this->assertSame($result['data']['user']['id'], $user->id);
        $this->assertSame($result['data']['image']['id'], $comment->commented_item->id);
        $this->assertSame($result['data']['image']['description'], $comment->commented_item->description);
        $this->assertSame($result['data']['image']['file_path'], $comment->commented_item->file_path);
        $this->assertSame($result['data']['image']['size'], $comment->commented_item->size);
        $this->assertSame($result['data']['image']['file_name'], $comment->commented_item->file_name);
        $this->assertSame($result['data']['comment'], $newComment);
    }

    /**
     * @test
     */
    public function it_deletes_a_comment_on_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class,
        ]);

        $this->delete('api/comments/' . $comment->id, [], $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data'], 'Success');
        $this->assertNull($comment->fresh());
    }

    /**
     * @test
     */
    public function it_comments_on_a_restricted_photo_a_gets_refused()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        factory(LeaguePermission::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'type' => LeaguePermission::TYPE_COMMENT,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        $comment = $this->faker->paragraph;

        $data = [
            'comment' => $comment,
            'commented_item_type' => Image::class,
        ];


        $this->post('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

        $this->seeStatusCode(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['error']['message'], 'User is not a member of the league, can not perform this action. Must be member.');
    }

    /**
     * @test
     */
    public function it_edits_a_comment_that_is_not_mine_and_get_refused()
    {
        $user = $this->createAndLoginABasicUser();

        $comment = factory(Comment::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $newComment = $this->faker->paragraph;

        $data = [
            'comment' => $newComment,
        ];

        $this->put('api/comments/' . $comment->id, $data, $this->getHeaders());

        $this->seeStatusCode(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['error']['message'], "You can not edit other people's comment");
    }

    /**
     * @test
     */
    public function it_deletes_a_comment_that_is_not_mine_and_get_refused()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comment = factory(Comment::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class,
        ]);

        $this->delete('api/comments/' . $comment->id, [], $this->getHeaders());

        $this->seeStatusCode(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['error']['message'], "You can not delete other people's comment");
    }

    /**
     * @test
     */
    public function it_reads_all_comments_on_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comments = factory(Comment::class, 20)->create([
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class
        ]);

        $this->get('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach($comments as $comment) {

            if ($i < ApiController::DEFAULT_LIMIT) {
                $this->assertSame($result['data'][$i]['user']['first_name'], $comment->user->first_name);
                $this->assertSame($result['data'][$i]['user']['last_name'], $comment->user->last_name);
                $this->assertSame($result['data'][$i]['user']['gender'], $comment->user->gender);
                $this->assertSame($result['data'][$i]['user']['id'], $comment->user->id);
                $this->assertSame($result['data'][$i]['image']['id'], $comment->commented_item->id);
                $this->assertSame($result['data'][$i]['image']['description'], $comment->commented_item->description);
                $this->assertSame($result['data'][$i]['image']['file_path'], $comment->commented_item->file_path);
                $this->assertSame($result['data'][$i]['image']['size'], $comment->commented_item->size);
                $this->assertSame($result['data'][$i]['image']['file_name'], $comment->commented_item->file_name);
                $this->assertSame($result['data'][$i]['comment'], $comment->comment);
            }

            $i++;
        }

        $this->assertCount(ApiController::DEFAULT_LIMIT, $result['data']);
    }

    /**
     * @test
     */
    public function it_comments_a_restricted_for_members_photo_but_im_member_and_can()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        factory(LeaguePermission::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'type' => LeaguePermission::TYPE_COMMENT,
            'permission' => LeaguePermission::PERMISSION_ONLY_MEMBERS
        ]);

        factory(PlayerLeague::class)->create([
            'league_id' => $leaguePhoto->league->id,
            'player_id' => $user->id,
        ]);

        $comment = $this->faker->paragraph;

        $data = [
            'comment' => $comment,
            'commented_item_type' => Image::class,
        ];

        $this->post('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class, $data, $this->getHeaders());

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
        $this->assertSame($result['data']['comment'], $comment);

    }

    /**
     * @test
     */
    public function it_reads_all_comments_on_a_photo_with_pagination()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comments = factory(Comment::class, 26)->create([
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class
        ]);

        $this->get('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&offset=16&limit=5', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $i = 0;
        foreach($comments as $comment) {

            if ($i > 15 && $i < 20) {
                $this->assertSame($result['data'][$i-16]['user']['first_name'], $comment->user->first_name);
                $this->assertSame($result['data'][$i-16]['user']['last_name'], $comment->user->last_name);
                $this->assertSame($result['data'][$i-16]['user']['gender'], $comment->user->gender);
                $this->assertSame($result['data'][$i-16]['user']['id'], $comment->user->id);
                $this->assertSame($result['data'][$i-16]['image']['id'], $comment->commented_item->id);
                $this->assertSame($result['data'][$i-16]['image']['description'], $comment->commented_item->description);
                $this->assertSame($result['data'][$i-16]['image']['file_path'], $comment->commented_item->file_path);
                $this->assertSame($result['data'][$i-16]['image']['size'], $comment->commented_item->size);
                $this->assertSame($result['data'][$i-16]['image']['file_name'], $comment->commented_item->file_name);
                $this->assertSame($result['data'][$i-16]['comment'], $comment->comment);
            }

            $i++;
        }

        $this->assertCount(5, $result['data']);
    }

    /**
     * @test
     */
    public function it_reads_total_count_of_comments_on_a_photo()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        factory(Comment::class, 20)->create([
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class
        ]);

        $this->get('api/comments/' . $leaguePhoto->photo->id . '?type=' . Image::class . '&total_count=true', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);

        $this->assertSame($result['data']['count'], 20);
    }

    /**
     * @test
     */
    public function it_deletes_any_comment_as_league_owner_and_gets_deleted()
    {
        $user = $this->createAndLoginABasicUser();

        $league = factory(LeagueOrganization::class)->create([
            'user_id' => $user->id
        ]);

        $leaguePhoto = factory(LeaguePhoto::class)->create([
            'league_id' => $league->id
        ]);

        $comment = factory(Comment::class)->create([
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class,
        ]);

        $this->delete('api/comments/' . $comment->id, [], $this->getHeaders());
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['data'], "Success");
    }

    /**
     * @test
     */
    public function it_cant_deletes_any_comment()
    {
        $user = $this->createAndLoginABasicUser();

        $leaguePhoto = factory(LeaguePhoto::class)->create();

        $comment = factory(Comment::class)->create([
            'commented_item_id' => $leaguePhoto->photo->id,
            'commented_item_type' => Image::class,
        ]);

        $this->delete('api/comments/' . $comment->id, [], $this->getHeaders());

        $this->seeStatusCode(HTTPStatusCode::FORBIDDEN);
        $this->isJson();
        $result = json_decode($this->response->content(), true);
        $this->assertSame($result['error']['message'], "You can not delete other people's comment");
    }
}