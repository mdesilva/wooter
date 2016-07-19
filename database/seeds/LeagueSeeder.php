<?php

use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Notifications\CreateNotificationCommand;
use Wooter\Division;
use Wooter\Game;
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
use Wooter\Notification;
use Wooter\PlayerPosition;
use Wooter\PlayerTeam;
use Wooter\PlayerBasketballStat;
use Wooter\RegularStage;
use Wooter\SeasonCompetition;
use Wooter\Sport;
use Wooter\Team;
use Wooter\TeamStage;
use Wooter\User;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;

class LeagueSeeder extends Seeder
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
            $user = User::whereEmail('carlos@wooter.co')->first();

            $this->createFullCompetition($user, 'NBA', Sport::BASKETBALL);
            $this->createFullCompetition($user, 'Spanish Basketball League', Sport::BASKETBALL);
            $this->createFullCompetition($user, 'Champions League', Sport::BASKETBALL, 'past');
            $this->createFullCompetition($user, 'World Cup', Sport::BASKETBALL, 'archived');

            $fan = factory(User::class)->create();
            factory(LeagueReview::class)->create(['reviewer_id' => $fan->id]);

            $notificationData = [
                'user_id' => $user->id,
                'title' => 'A new player have joined your league.',
                'text' => 'Player ' . $fan->name . ' have joined Professional Spanish League',
                'event_type' => Notification::TYPE_PLAYER_JOIN_LEAGUE
            ];

            $this->dispatchFromArray(CreateNotificationCommand::class, $notificationData);

        } catch (Exception $e) {
            dd($e->getMessage(), $e->getLine(), $e->getFile());
        }
    }

    /**
     * @param        $user
     * @param        $name
     * @param        $sportId
     * @param string $type
     */
    private function createFullCompetition($user, $name, $sportId, $type = 'active')
    {
        switch ($type) {
            case 'active':
                $league = factory(LeagueOrganization::class)->create(['name' => $name, 'user_id' => $user->id, 'sport_id' => $sportId]);
                $competition = factory(SeasonCompetition::class)->create(['organization_id' => $league->id, 'organization_type' => LeagueOrganization::class]);
                break;
            case 'past':
                $league = factory(LeagueOrganization::class)->create(['name' => $name, 'user_id' => $user->id, 'sport_id' => $sportId]);
                $competition = factory(SeasonCompetition::class)->create(['organization_id' => $league->id, 'organization_type' => LeagueOrganization::class, 'starts_at' => Carbon\Carbon::create()->subMonth(5), 'ends_at' => Carbon\Carbon::create()->subMonth(2)]);
                break;
            case 'archived':
                $league = factory(LeagueOrganization::class)->create(['name' => $name, 'user_id' => $user->id, 'sport_id' => $sportId, 'archived' => true]);
                $competition = factory(SeasonCompetition::class)->create(['organization_id' => $league->id, 'organization_type' => LeagueOrganization::class]);
                break;
        }

        factory(LeagueBasics::class)->create(['league_id' => $league->id]);
        factory(LeagueDetails::class)->create(['league_id' => $league->id]);
        factory(LeaguePhoto::class, 30)->create(['league_id' => $league->id]);
        factory(LeagueVideo::class, 30)->create(['league_id' => $league->id]);
        factory(LeagueFeature::class, 3)->create(['league_id' => $league->id]);
        factory(LeagueGameVenue::class, 5)->create(['league_id' => $league->id]);
        factory(LeagueLocation::class, 5)->create(['league_id' => $league->id]);
        factory(LeagueReview::class, 20)->create(['league_id' => $league->id]);
        factory(LeaguePrice::class, 2)->create(['league_id' => $league->id]);

        $this->createTeams(Sport::BASKETBALL, SeasonCompetition::class, $competition->id, $league);
    }

    /**
     * @param $sportId
     * @param $competitionType
     * @param $competitionId
     * @param $league
     */
    private function createTeams($sportId, $competitionType, $competitionId, $league)
    {
        $teams = factory(Team::class, 5)->create(['sport_id' => $sportId]);

        $firstTeamId = $teams->first()->id;
        $lastTeamId = $teams->last()->id;
        $count = $firstTeamId;

        $stage = factory(RegularStage::class)->create([
            'competition_id' => $competitionId,
            'competition_type' => $competitionType,
        ]);

        $division = factory(Division::class)->create(['name' => $this->faker->name, 'stage_id' => $stage->id, 'stage_type' => RegularStage::class]);

        foreach ($teams as $team) {

            if ($count === $lastTeamId) {
                $count = $firstTeamId;
            } else {
                $count++;
            }

            $game = factory(Game::class)->create([
                'home_team_id' => $team->id,
                'visiting_team_id' => $count,
                'stage_id' => $stage->id,
                'stage_type' => RegularStage::class,
            ]);

            $team->divisions()->attach($division);

            $teamStage = new TeamStage;
            $teamStage->team_id = $team->id;
            $teamStage->stage_id = $stage->id;
            $teamStage->stage_type = RegularStage::class;
            $teamStage->save();

            $players = factory(User::class, 12)->create();

            foreach ($players as $player) {
                $playerTeam = factory(PlayerTeam::class)->create(['player_id' => $player->id, 'team_id' => $team->id, 'stage_id' => $stage->id, 'stage_type'=> RegularStage::class]);
                factory(PlayerPosition::class)->create(['player_team_id' => $playerTeam->id]);

                factory(PlayerBasketballStat::class)->create([
                    'player_id' => $player->id,
                    'team_id' => $team->id,
                    'game_id' => $game->id,
                    'jersey' => $player->id . ' ' . $player->first_name,
                ]);
            }

            $league->teams()->attach($team->id);
            $league->players()->attach($this->playerTeamRepository->getPlayerIdsByTeamIdAndStage($team->id, RegularStage::class, $stage->id));
        }
    }

}
