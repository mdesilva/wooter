<?php

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\City;
use Wooter\CompetitionWeek;
use Wooter\Division;
use Wooter\Game;
use Wooter\GameVenue;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;
use Wooter\LeagueFeature;
use Wooter\LeagueGameVenue;
use Wooter\LeagueLocation;
use Wooter\LeagueOrganization;
use Wooter\LeaguePhoto;
use Wooter\LeaguePrice;
use Wooter\LeagueReview;
use Wooter\LeagueVideo;
use Wooter\Location;
use Wooter\PlayerLeague;
use Wooter\PlayerPosition;
use Wooter\PlayerTeam;
use Wooter\RegularStage;
use Wooter\SeasonCompetition;
use Wooter\Sport;
use Wooter\Team;
use Wooter\TeamBasketballStat;
use Wooter\TeamStage;
use Wooter\User;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;

class DreamLeaguesSeeder extends Seeder
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $playerTeamRepository;
    /**
     * @var Generator
     */
    private $faker;

    protected $players = [
        [
            'first_name' => 'Chris',
            'last_name' => 'Coughlin',
            'email' => 'lefosse2.dreamleagues@gmail.com',
            'phone' => '(718) 354-9229',
            'paid' => false,
        ],
        [
            'first_name' => 'Rob',
            'last_name' => 'Campanella',
            'email' => 'Xr0bbiex23@aol.com',
            'phone' => '(718) 724-3011',
            'paid' => false,
        ],
        [
            'first_name' => 'Engjell',
            'last_name' => 'Zuna',
            'email' => 'engjellzuna@yahoo.com',
            'phone' => '(347) 235-3486',
            'paid' => false,
        ],
        [
            'first_name' => 'Edd',
            'last_name' => 'Barcia',
            'email' => 'edward.barcia@gmail.com',
            'phone' => '(347) 712-9802',
            'paid' => false,
        ],
        [
            'first_name' => 'Michael',
            'last_name' => 'Berteletti',
            'email' => 'mikebertel123@aol.com',
            'phone' => '(718) 300-1788',
            'paid' => false,
        ],
        [
            'first_name' => 'Kevin',
            'last_name' => 'Althoff',
            'email' => 'kevalthoff13@gmail.com',
            'phone' => '1(347)570-5377',
            'paid' => false,
        ],
        [
            'first_name' => 'Rich',
            'last_name' => 'Fenimore',
            'email' => 'Richmeister20@yahoo.com',
            'phone' => '(646) 243-7508',
            'paid' => false,
        ],
        [
            'first_name' => 'Joseph',
            'last_name' => 'Priolo',
            'email' => 'Joepriolo96@gmail.com',
            'phone' => '(917) 885-3283',
            'paid' => true,
        ],
        [
            'first_name' => 'Michaelangelo',
            'last_name' => 'Anastasio',
            'email' => 'michaelangeloanastasio@gmail.com',
            'phone' => '(347) 633-0779',
            'paid' => false,
        ],
        [
            'first_name' => 'Ray',
            'last_name' => 'Savage',
            'email' => 'Savager2@misericordia.edu',
            'phone' => '(917) 647-7077',
            'paid' => false,
        ],
        [
            'first_name' => 'Vinny',
            'last_name' => '',
            'email' => 'vincentmastrogiulio@yahoo.com',
            'phone' => '(347) 254-9983',
            'paid' => true,
        ],
        [
            'first_name' => 'Brian',
            'last_name' => 'Finnegan',
            'email' => 'brianb15@aol.com',
            'phone' => '(917) 757-4601',
            'paid' => true,
        ],
        [
            'first_name' => 'James',
            'last_name' => 'Iuliucci',
            'email' => 'J.iuliucci@aol.com',
            'phone' => '(917) 459-4579',
            'paid' => true,
        ],
        [
            'first_name' => 'Frank',
            'last_name' => 'Cuomo',
            'email' => 'Frank.cuomo@aol.com',
            'phone' => '(718) 290-4057',
            'paid' => false,
        ],
        [
            'first_name' => 'Jonathan',
            'last_name' => 'Kravitz',
            'email' => 'jkravitz15@aol.com',
            'phone' => '(917) 225-9644',
            'paid' => true,
        ],
        [
            'first_name' => 'Billy',
            'last_name' => 'Podurgiel',
            'email' => 'Bpforthree@aol.com',
            'phone' => '(347) 551-1091',
            'paid' => true,
        ],
        [
            'first_name' => 'Joe',
            'last_name' => 'Fung',
            'email' => 'Joe_fung22@yahoo.com',
            'phone' => '(929) 262-2470',
            'paid' => false,
        ],
        [
            'first_name' => 'Nick',
            'last_name' => 'Rentas',
            'email' => 'Nickrentas3@gmail.com',
            'phone' => '+1 (718) 887-5317',
            'paid' => false,
        ],
        [
            'first_name' => 'Dylan',
            'last_name' => 'Fusco',
            'email' => 'dylanfusco@gmail.com',
            'phone' => '(347) 728-1523',
            'paid' => false,
        ],
        [
            'first_name' => 'Nick',
            'last_name' => 'Etri',
            'email' => 'nicholas_etri@aol.com',
            'phone' => '(718) 887-4110',
            'paid' => false,
        ],
        [
            'first_name' => 'Dave',
            'last_name' => 'Troianiello',
            'email' => 'dtroi621@gmail.com',
            'phone' => '(917) 524-2066',
            'paid' => false,
        ],
        [
            'first_name' => 'Mike',
            'last_name' => 'Lefosse',
            'email' => 'lefosse.dreamleagues@gmail.com',
            'phone' => '(347) 684-0889',
            'paid' => false,
        ],
        [
            'first_name' => 'Pete',
            'last_name' => 'Kennedey',
            'email' => 'kennedey.dreamleagues@gmail.com',
            'phone' => '(646) 262-2071',
            'paid' => false,
        ],
    ];

    protected $divisions = [
        'Elite (A)',
        'Gold (B)',
        'Purple (C)',
    ];

    protected $teams = [
        [
            'name' => 'Monstars',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'lefosse.dreamleagues@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Bearcats',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'Xr0bbiex23@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Georgetown Hoyas',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'engjellzuna@yahoo.com',
                ],
            ]
        ],
        [
            'name' => 'Oregon Ducks',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'edward.barcia@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Toronto Raptors',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'mikebertel123@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Rockets',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'kevalthoff13@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Baylor Bears',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'Richmeister20@yahoo.com',
                ],
            ]
        ],
        [
            'name' =>'Magic',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'Joepriolo96@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Milwaukee Bucks',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'michaelangeloanastasio@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Buck Eyes',
            'division' => 'Elite (A)',
            'players' => [
                [
                    'email' => 'dylanfusco@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Heat',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'Savager2@misericordia.edu',
                ],
            ]
        ],
        [
            'name' => 'Michigan State Spartan',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'vincentmastrogiulio@yahoo.com',
                ],
            ]
        ],
        [
            'name' => 'Tropics',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'brianb15@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Bel Air Academy',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'J.iuliucci@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Timberwolves',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'Frank.cuomo@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Cavs',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'jkravitz15@aol.com',
                ],
            ]
        ],
        [
            'name' => '76ers',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'Bpforthree@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Nets',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'Nickrentas3@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Clippers',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'nicholas_etri@aol.com',
                ],
            ]
        ],
        [
            'name' => 'Banna Hammocks',
            'division' => 'Gold (B)',
            'players' => [
                [
                    'email' => 'kennedey.dreamleagues@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Kings',
            'division' => 'Purple (C)',
            'players' => [
                [
                    'email' => 'dtroi621@gmail.com',
                ],
            ]
        ],
        [
            'name' => 'Flaming Flamingos',
            'division' => 'Purple (C)',
            'players' => [
                [
                    'email' => 'lefosse.dreamleagues@gmail.com',
                ],
            ]
        ],
    ];

    protected $games = [
        [
            'home_team' => 'Banna Hammocks',
            'visitor_team' => 'Nets',
            'home_team_score' => '71',
            'visitor_team_score' => '57',
            'date' => '2016-05-26 22:00:00',
        ],
        [
            'home_team' => 'Bel Air Academy',
            'visitor_team' => 'Heat',
            'home_team_score' => '92',
            'visitor_team_score' => '86',
            'date' => '2016-05-26 21:00:00',
        ],
        [
            'home_team' => 'Banna Hammocks',
            'visitor_team' => 'Timberwolves',
            'home_team_score' => '50',
            'visitor_team_score' => '50',
            'date' => '2016-05-26 20:00:00',
        ],
        [
            'home_team' => 'Heat',
            'visitor_team' => 'Clippers',
            'home_team_score' => '53',
            'visitor_team_score' => '52',
            'date' => '2016-05-26 19:00:00',
        ],
        [
            'home_team' => 'Buck Eyes',
            'visitor_team' => 'Bearcats',
            'home_team_score' => '84',
            'visitor_team_score' => '63',
            'date' => '2016-05-26 18:00:00',
        ],
        [
            'home_team' => 'Flaming Flamingos',
            'visitor_team' => 'Monstars',
            'home_team_score' => '73',
            'visitor_team_score' => '67',
            'date' => '2016-05-26 15:00:00',
        ],
    ];

    /**
     * @param PlayerTeamRepository $playerTeamRepository
     * @param Generator     $faker
     */
    public function __construct(PlayerTeamRepository $playerTeamRepository, Generator $faker)
    {
        $this->playerTeamRepository = $playerTeamRepository;
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $user = User::whereEmail('vip@wooter.co')->first();

            $this->createFullCompetition($user, 'Dream Leagues', Sport::BASKETBALL);

        } catch (Exception $e) {
            dd($e->getMessage(), $e->getLine(), $e->getFile());
        }
    }

    /**
     * @param        $user
     * @param        $name
     * @param        $sportId
     */
    private function createFullCompetition($user, $name, $sportId)
    {

        $city = factory(City::class)->create([
            'name' => 'Staten Island',
            'name_localized' => 'staten_island',
            'country_id' => 236,
        ]);

        $location = factory(Location::class)->create([
            'name' => 'Fast Break (Staten Island)',
            'city_id' => $city->id,
            'country_id' => 236,
            'zip' => 10309,
            'state' => 'NY',
            'street' => '236 Richmond Valley Rd, 10309, NY',
            'full_address' => '236 Richmond Valley Rd',
        ]);

        $gameVenue = factory(GameVenue::class)->create([
            'location_id' => $location->id,
            'number_of_courts' => 4,
            'court_name' => 'Fast Break (Staten Island)',
        ]);

        $league = factory(LeagueOrganization::class)->create([
            'name' => $name,
            'user_id' => $user->id,
            'sport_id' => $sportId,
            'email' => 'vip@wooter.co'
        ]);

        factory(LeagueGameVenue::class)->create([
            'game_venue_id' => $gameVenue->id,
            'league_id'=> $league->id,
        ]);

        $competition = factory(SeasonCompetition::class)->create([
            'organization_id' => $league->id,
            'organization_type' => LeagueOrganization::class,
            'starts_at' => Carbon::create()->subMonth(1),
            'ends_at' => Carbon::create()->addMonth(3)
        ]);

        $stage = factory(RegularStage::class)->create([
            'competition_id' => $competition->id,
            'competition_type' => SeasonCompetition::class,
        ]);

        factory(LeagueBasics::class)->create(['league_id' => $league->id]);
        factory(LeagueDetails::class)->create(['league_id' => $league->id]);

        foreach ($this->players as $player) {
            $player = factory(User::class)->create([
                'first_name' => $player['first_name'],
                'last_name' => $player['last_name'],
                'email' => $player['email'],
                'phone' => $player['phone'],
            ]);

            if (PlayerLeague::wherePlayerId($player->id)->whereLeagueId($league->id)->count() == 0) {
                $playerLeague = new PlayerLeague;
                $playerLeague->league_id = $league->id;
                $playerLeague->player_id = $player->id;
                $playerLeague->save();
            }

        }
        foreach ($this->divisions as $division) {
            factory(Division::class)->create([
                'name' => $division,
                'stage_id' => $stage->id,
                'stage_type' => RegularStage::class
            ]);
        }


        foreach ($this->teams as $team) {
            $player = User::whereEmail($team['players'][0]['email'])->first();

            $team = factory(Team::class)->create([
                'name' => $team['name'],
                'sport_id' => $sportId,
                'captain_id' => $player->id,
            ]);
            $playerTeam = PlayerTeam::wherePlayerId($player->id)->whereTeamId($team->id)->whereStageId($stage->id)->first();

            if ( is_null($playerTeam)) {
                $playerTeam = factory(PlayerTeam::class)->create([
                    'player_id' => $player->id,
                    'team_id' => $team->id,
                    'stage_id' => $stage->id, 'stage_type'=> RegularStage::class
                ]);

                factory(PlayerPosition::class)->create([
                    'player_team_id' => $playerTeam->id
                ]);
            }

            $division = Division::whereName($team['division'])->first();

            $team->divisions()->attach($division);

            $teamStage = new TeamStage;
            $teamStage->team_id = $team->id;
            $teamStage->stage_id = $stage->id;
            $teamStage->stage_type = RegularStage::class;
            $teamStage->save();

            $league->teams()->attach($team->id);
        }

        foreach ($this->games as $game) {
            $homeTeam = Team::whereName($game['home_team'])->first();
            $visitorTeam = Team::whereName($game['visitor_team'])->first();

            $time = new Carbon($game['date']);

            $competitionWeek = CompetitionWeek::whereStageId($stage->id)
                ->whereStageType(RegularStage::class)
                ->whereStartsAt($time->startOfWeek())
                ->whereEndsAt($time->endOfWeek())
                ->first();

            if ( ! $competitionWeek) {
                $competitionWeek = factory(CompetitionWeek::class)->create([
                    'stage_id' => $stage->id,
                    'stage_type'=> RegularStage::class,
                    'name'=> $this->faker->name,
                    'starts_at'=> $time->startOfWeek(),
                    'ends_at'=> $time->endOfWeek(),
                ]);
            }

            $gameObject = factory(Game::class)->create([
                'home_team_id' => $homeTeam->id,
                'visiting_team_id' => $visitorTeam->id,
                'game_venue_id' => $gameVenue->id,
                'competition_week_id' => $competitionWeek->id,
                'stage_id' => $stage->id,
                'sport_id' => Sport::BASKETBALL,
                'stage_type'=> RegularStage::class,
                'time'=> $game['date'],
            ]);

            factory(TeamBasketballStat::class)->create([
                'game_id' => $gameObject->id,
                'team_id' => $homeTeam->id,
                'first_quarter_score' => 0,
                'second_quarter_score' => 0,
                'third_quarter_score' => 0,
                'fourth_quarter_score' => 0,
                'final_score' => $game['home_team_score'],
                'win' => $game['home_team_score'] > $game['visitor_team_score'] ? 1 : 0,
                'loss' => $game['home_team_score'] < $game['visitor_team_score'] ? 1 : 0,
                'draw' => $game['home_team_score'] == $game['visitor_team_score'] ? 1 : 0,
            ]);

            factory(TeamBasketballStat::class)->create([
                'game_id' => $gameObject->id,
                'team_id' => $visitorTeam->id,
                'first_quarter_score' => 0,
                'second_quarter_score' => 0,
                'third_quarter_score' => 0,
                'fourth_quarter_score' => 0,
                'final_score' => $game['visitor_team_score'],
                'win' => $game['visitor_team_score'] > $game['home_team_score'] ? 1 : 0,
                'loss' => $game['visitor_team_score'] < $game['home_team_score'] ? 1 : 0,
                'draw' => $game['visitor_team_score'] == $game['home_team_score'] ? 1 : 0,
            ]);
        }
    }

}
