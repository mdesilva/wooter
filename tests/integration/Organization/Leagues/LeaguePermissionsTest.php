<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\LeagueOrganization;
use Wooter\LeaguePermission;
use Wooter\LeaguePrice;
use Wooter\Wooter\Contracts\HTTPStatusCode;

class LeaguePermissionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_edits_a_league_permission()
    {
        $this->createAndLoginAnOrganization();
        $this->createLeague();

        $league = LeagueOrganization::first();

        $type = LeaguePermission::TYPE_LIKE;
        $permission = LeaguePermission::PERMISSION_EVERYBODY;

        $data = [
            'type' => $type,
            'permission' => $permission,
        ];

        $this->post('api/leagues/' . $league->id . '/permissions', $data, $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);
        $this->assertEquals($result['data']['league_id'], $league->id);
        $this->assertEquals($result['data']['type'], $type);
        $this->assertEquals($result['data']['permission'], $permission);
    }

    /**
     * @test
     */
    public function it_reads_all_permissions_for_a_league()
    {
        $user = $this->createAndLoginAnOrganization();

        $league = factory(LeagueOrganization::class)->create([
            'user_id' => $user->id
        ]);

        $leaguePermissions = factory(LeaguePermission::class, 20)->create([
            'league_id' => $league->id
        ]);

        $this->get('api/leagues/' . $league->id . '/permissions', $this->getHeaders());

        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);

        $i = 0;
        foreach ($leaguePermissions as $leaguePermission) {
            $this->assertEquals($result['data'][$i]['league_id'], $leaguePermission->league->id);
            $this->assertEquals($result['data'][$i]['type'], $leaguePermission->type);
            $this->assertEquals($result['data'][$i]['permission'], $leaguePermission->permission);
            $i++;
        }
    }

}
