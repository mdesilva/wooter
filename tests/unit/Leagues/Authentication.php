<?php

use Illuminate\Foundation\Bus\DispatchesJobs;

use Wooter\Commands\Qnap\CreateQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\ReadQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\ReadQnapOrganizationLeagueCommand;
use Wooter\Commands\Qnap\DeleteQnapLeagueVideoCommand;
use Wooter\Commands\Qnap\UpdateQnapLeagueVideoCommand;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;


class LeaugePasscodeUnitTest extends TestCase
{
    use DispatchesJobs;

    protected $headers = [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
    ];

    protected $qnapFolder = array
    (
        46 => array
        (
            "56e18e4723d5b" => array
            (
                "league_id" => "46",
                "video_hash" => "56e18e4723d5b",
                "file_name" => "iamarenamedvideo",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\iamarenamedvideo.mp4"

            )
        ),

        47 => array
        (
            "56e1c4b214c95" => array
            (
                "league_id" => "47",
                "video_hash" => "56e1c4b214c95",
                "file_name" => "video3",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\video3.mp4"
            ),

            "56e192e1e8494" => array
            (
                "league_id" => "47",
                "video_hash" => "56e192e1e8494",
                "file_name" => "video1",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\video1.mp4"
            ),
            "56e194c1f1b2e" => array
            (
                "league_id" => "47",
                "video_hash" => "56e194c1f1b2e",
                "file_name" => "video2",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\video2.mp4"
            )

        ),
        48 => array
        (
            "56e18e4723d5bb" => array
            (
                "league_id" => "48",
                "video_hash" => "56e18e4723d5bb",
                "file_name" => "IamChanged",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\IamChanged.mp4"

            )
        ),

        50 => array
        (
            "56e18e4723d5bbc" => array
            (
                "league_id" => "50",
                "video_hash" => "56e18e4723d5bbc",
                "file_name" => "Iamupdatedagain",
                "src" => "http://dreamleagues.myqnapcloud.com:8086/qnap/LeagueVideosWooterV1/Alumni_Softball_League_1657\SI_Men_s_Softball_League___Saturday_4900\Iamupdatedagain.mp4"

            )
        ),



    );



    protected function registerUser($preselectedRole = Role::ORGANIZATION) {
        Session::start();

        $user =  factory(User::class)->create();


        factory(Organization::class)->create([

            'user_id' => $user->id,
            'name' => "shamx"
        ]);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    protected function verifyUser(User $user)
    {
        return $user->verify();
    }




    /**
     * @test
     */
    public function read_league_videos()
    {
        //Request Params
        $request = ["email"=>"wooter@wooter.co",
                    "password"=>"123456"];
        $this->call('Post', 'api/authenticate', $request);
        $data =  json_decode($this->response->content(), TRUE);

        dd($data);
        $videoDelete = array();

        $videoAdd = array();

        $videoUpdate = array();

        //Request Params
        $request = [
            'video' => "all",

        ];



        //Generate a dispacth request;
       // $this->dispatchFromArray(ReadQnapLeagueVideoCommand::class, $request);
        //dd("done");
        //$this->post('api/league-passcode', $request, $this->headers);
       // $this->call('POST', 'api/league-passcode', $request);

        $this->call('GET', 'api/qnap/getVideos', $request);
        $data =  json_decode($this->response->content(), TRUE);

        $server = $data["data"];


        foreach($server as $leagueId => $videos)
        {
            foreach($videos as $videoHash => $video)
            {


               if(!empty($this->qnapFolder[$leagueId][$videoHash]))
               {
                   continue;
               }

                $videoDelete[$leagueId][$videoHash] = $video;
            }
        }



        foreach($this->qnapFolder as $leagueId => $videos)
        {
            foreach($videos as $videoHash => $video)
            {

                if(!empty($server[$leagueId][$videoHash]))
                {
                    continue;
                }

                $videoAdd[$leagueId][$videoHash] = $video;
            }
        }


        foreach($server as $leagueId => $videos)
        {
            foreach($videos as $videoHash => $video)
            {


                if(!empty($this->qnapFolder[$leagueId][$videoHash]) && $this->qnapFolder[$leagueId][$videoHash]["file_name"] != $server[$leagueId][$videoHash]["file_name"])
                {
                    $videoUpdate[$leagueId][$videoHash] = $this->qnapFolder[$leagueId][$videoHash];
                }
            continue;

            }
        }






        $request = [
            'video' => $videoDelete,

        ];
        $this->dispatchFromArray(DeleteQnapLeagueVideoCommand::class, $request);

        $request = [
            'qnap_videos' => $videoAdd,

        ];
        $this->dispatchFromArray(CreateQnapLeagueVideoCommand::class, $request);


        $request = [
            'qnap_videos' => $videoUpdate,

        ];
        $this->call('POST', 'api/qnap/updateVideos', $request);
        //$this->dispatchFromArray(UpdateQnapLeagueVideoCommand::class, $request);


        dd("yes, Updated, deleted and also added");
        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);




    }


    /**
     * @test
     */
    public function create_league_videos()
    {



        //Request Params
        $request = [
            'qnap_videos' => $this->qnapFolder,

        ];



        //Generate a dispacth request;
        $this->dispatchFromArray(CreateQnapLeagueVideoCommand::class, $request);
        dd("done");
        $this->post('api/league-passcode', $request, $this->headers);
        $this->call('POST', 'api/league-passcode', $request);
        /*$this->call('POST', 'leagues/46/create-passcode', $request);


        $this->assertResponseOk();
        $this->isJson();
        $result = json_decode($this->response->content(),true);*/




    }




}
