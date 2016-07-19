<?php

use Wooter\Award;
use Wooter\BasketballRules;
use Wooter\City;
use Wooter\Comment;
use Wooter\CompetitionWeek;
use Wooter\Division;
use Wooter\Feature;
use Wooter\FollowLeague;
use Wooter\Game;
use Wooter\GameStructure;
use Wooter\GameVenue;
use Wooter\Image;
use Wooter\LeagueBasics;
use Wooter\LeagueDetails;
use Wooter\LeagueFeature;
use Wooter\LeagueGameVenue;
use Wooter\LeagueLocation;
use Wooter\LeagueOrganization;
use Wooter\LeaguePermission;
use Wooter\LeaguePhoto;
use Wooter\LeaguePrice;
use Wooter\LeagueReview;
use Wooter\LeagueVideo;
use Wooter\Like;
use Wooter\Location;
use Wooter\Notification;
use Wooter\PackageRequest;
use Wooter\PlayerLeague;
use Wooter\PlayerPosition;
use Wooter\PlayerTeam;
use Wooter\PlayoffStructure;
use Wooter\PlayerBasketballStat;
use Wooter\RegularStage;
use Wooter\Role;
use Wooter\SeasonCompetition;
use Wooter\SeasonStructure;
use Wooter\ServiceRequest;
use Wooter\Sport;
use Wooter\Stat;
use Wooter\Team;
use Wooter\TeamBasketballStat;
use Wooter\TeamFootballStat;
use Wooter\TeamHockeyStat;
use Wooter\TeamSoccerStat;
use Wooter\User;
use Wooter\Video;
use Wooter\Weekday;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

if (! function_exists('newModel')) {
    function newModel($model, $params, $key, $defaultParams = []){
        return isset($params[$key]) ? $params[$key] : factory($model)->create($defaultParams)->id;
    }
}

$factory->define(User::class, function (Faker\Generator $faker, $params = []) {
    return [
        'email' => $faker->email,
        'first_name' => $faker->firstNameFemale,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'gender' => 'male',
        'picture_id' => newModel(Image::class, $params, 'picture_id'),
        'birthday' => $faker->date(),
        'password' => bcrypt(User::DEFAULT_PASSWORD),
        'remember_token' => str_random(10),
    ];
});

$factory->define(LeagueOrganization::class, function (Faker\Generator $faker, $params = []) {
    $args = func_get_arg(1);

    if ( ! isset($args['user_id'])) {
        $userOwnerOfOrganization = factory(User::class)->create();
        $userOwnerOfOrganization->roles()->attach(Role::ORGANIZATION);
        $userOwnerOfOrganization->push();
        $userId = $userOwnerOfOrganization->id;
    }

    return [
        'user_id' => isset($userId) ? $userId : '',
        'name' => $faker->name,
        'sport_id' => Sport::BASKETBALL,
        'email' => $faker->email,
        'description' => $faker->text,
        'facebook' => $faker->url,
        'twitter' => $faker->url,
        'instagram' => $faker->url,
        'pinterest' => $faker->url,
        'google' => $faker->url,
        'archived' => false,
    ];
});

$factory->define(ServiceRequest::class, function (Faker\Generator $faker, $params = []) {
    return [
        'email' => $faker->email,
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'sport' => 'Basketball',
        'type' => ServiceRequest::TYPE_VIDEO,
        'number_of_players' => $faker->numberBetween(2,15),
        'number_of_teams' => $faker->numberBetween(2,15),
        'number_of_games_per_team' => $faker->numberBetween(2,15),
    ];
});

$factory->define(PackageRequest::class, function (Faker\Generator $faker, $params = []) {
    return [
        'email' => $faker->email,
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'sport' => 'Basketball',
        'package_type' => PackageRequest::LEGEND_PACKAGE,
        'number_of_players' => $faker->numberBetween(2,15),
        'number_of_teams' => $faker->numberBetween(2,15),
        'number_of_games_per_team' => $faker->numberBetween(2,15),
        'full_game_footage' => $faker->boolean(),
        'game_highlights' => $faker->boolean(),
        'statistics' => $faker->boolean(),
        'pro_videography' => $faker->boolean(),
        'top_10' => $faker->boolean(),
        'weekly_recap' => $faker->boolean(),
        'player_photos' => $faker->boolean(),
        'team_photos' => $faker->boolean(),
        'promo_video' => $faker->boolean(),
        'media_coverage' => $faker->boolean(),
        'blog_exposure' => $faker->boolean()
    ];
});

$factory->define(LeagueBasics::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'logo_id' => newModel(Image::class, $params, 'logo_id'),
        'min_age' => $faker->numberBetween(5,25),
        'max_age' => $faker->numberBetween(26,120),
        'gender' => 'male',
    ];
});

$factory->define(LeagueLocation::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'location_id' => newModel(Location::class, $params, 'location_id'),
    ];
});

$factory->define(GameStructure::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'name_localized' => $faker->domainName,
    ];
});

$factory->define(PlayoffStructure::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'name_localized' => $faker->domainName,
    ];
});

$factory->define(SeasonStructure::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'name_localized' => $faker->domainName,
    ];
});

$factory->define(LeagueDetails::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'description' => $faker->paragraph(),
        'number_of_teams' => $faker->numberBetween(1,5),
        'players_per_team' => $faker->numberBetween(2,10),
        'games_per_team' => $faker->numberBetween(1,5),
        'max_players' => $faker->numberBetween(2,11),
        'game_duration' => 60,
        'time_period' => $faker->numberBetween(90,120),
    ];
});

$factory->define(SeasonCompetition::class, function (Faker\Generator $faker, $params = []) {
    return [
        'name' => $faker->name,
        'organization_id' => newModel(LeagueOrganization::class, $params, 'organization_id'),
        'organization_type' => LeagueOrganization::class,
        'starts_at' => Carbon\Carbon::create()->subMonth(1),
        'ends_at' => Carbon\Carbon::create()->addMonth(2),
        'registration_opens_at' => $faker->date(),
        'registration_closes_at' => $faker->date(),
        'max_teams' => $faker->numberBetween(4,10),
        'min_teams' => $faker->numberBetween(2,4),
        'max_free_agents' => $faker->numberBetween(3,5),
        'min_free_agents' => $faker->numberBetween(1,2),
    ];
});

$factory->define(Award::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(),
    ];
});

$factory->define(Stat::class, function (Faker\Generator $faker) {
    return [
        'metric' => $faker->name,
        'points_scored' => $faker->randomFloat(2,2,100),
    ];
});

$factory->define(Sport::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'name_localized' => $faker->name,
    ];
});

$factory->define(City::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'name_localized' => $faker->citySuffix,
        'country_id' => $faker->numberBetween(1,100),
    ];
});

$factory->define(Location::class, function (Faker\Generator $faker, $params = []) {
    return [
        'name' => $faker->name,
        'full_address' => $faker->address,
        'zip' => $faker->postcode,
        'country_id' => $faker->numberBetween(1,100),
        'city_id' => newModel(City::class, $params, 'city_id'),
        'state' => 'NY',
        'street' => $faker->streetAddress,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'flat' => $faker->buildingNumber,
    ];
});

$factory->define(GameVenue::class, function (Faker\Generator $faker, $params = []) {
    return [
        'court_name' => $faker->name,
        'number_of_courts' => $faker->numberBetween(1,10),
        'location_id' => newModel(Location::class, $params, 'location_id'),
    ];
});

$factory->define(PlayerPosition::class, function (Faker\Generator $faker, $params = []) {
    return [
        'position_id' => 1,
        'player_team_id' => newModel(PlayerTeam::class, $params, 'player_team_id'),
    ];
});

$factory->define(LeagueGameVenue::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'game_venue_id' => newModel(GameVenue::class, $params, 'game_venue_id'),
    ];
});

$factory->define(LeagueFeature::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'feature_id' => $faker->numberBetween(1,10)
    ];
});

$factory->define(Feature::class, function (Faker\Generator $faker, $params = []) {
    return [
        'name' => $faker->firstName,
        'name_localized' => $faker->slug(2),
    ];
});

$factory->define(LeaguePhoto::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'image_id' => newModel(Image::class, $params, 'image_id'),
    ];
});

$factory->define(LeaguePrice::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'price' => $faker->numberBetween(10,100),
        'description' => $faker->sentence,
        'name' => $faker->sentence,
        'url' => $faker->url,
    ];
});

$factory->define(Image::class, function (Faker\Generator $faker) {

    $lastImage = Image::orderBy('id','desc')->first();

    if ($lastImage) {
        $nextId = intval($lastImage->id) + 1;
    } else {
        $nextId = 1;
    }

    $storePath = config('file.image.upload_path');
    $visiblePath = config('file.image.visible_path');

    $testPhotoPath = '/public/img/test/profile-big-league.png';

    $fileName = $faker->slug(2) . $nextId . '.' . 'png';

    exec('cp '. base_path($testPhotoPath) . ' ' . base_path($storePath) . $fileName);
    exec('cp '. base_path($testPhotoPath) . ' ' . base_path($storePath) . 'thumbnail' . $fileName);

    return [
        'file_path' => $visiblePath . $fileName,
        'thumbnail_path' => $visiblePath . 'thumbnail' . $fileName,
        'file_name' => $faker->name,
        'description' => $faker->paragraph(),
        'size' => 36000,
        'mime_type' => "image/png",
        'extension' => 'png',
    ];
});

$factory->define(Video::class, function (Faker\Generator $faker) {
    return [
        'file_path' => '/videos/testvideo.mp4',
        'file_name' => $faker->name,
        'description' => $faker->paragraph(),
        'size' => $faker->numberBetween(1000,100000),
        'mime_type' => $faker->mimeType,
        'extension' => $faker->fileExtension,
    ];
});

$factory->define(LeagueVideo::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'video_id' => newModel(Video::class, $params, 'video_id'),
    ];
});

$factory->define(Team::class, function (Faker\Generator $faker, $params = []) {
    return [
        'sport_id' => newModel(Sport::class, $params, 'sport_id'),
        'captain_id' => newModel(User::class, $params, 'captain_id'),
        'cover_photo_id' => newModel(Image::class, $params, 'cover_photo', ['description' => Team::COVER_PHOTO_DESCRIPTION]),
        'logo_id' => newModel(Image::class, $params, 'logo', ['description' => Team::LOGO_DESCRIPTION]),
        'description' => $faker->paragraph(),
        'name' => $faker->name,
    ];
});

$factory->define(PlayerTeam::class, function (Faker\Generator $faker, $params = []) {

    $playerId = newModel(User::class, $params, 'player_id');

    return [
        'player_id' => $playerId,
        'team_id' => newModel(Team::class, $params, 'team_id'),
        'jersey' => $playerId,
        'stage_type' => RegularStage::class,
        'stage_id' => newModel(RegularStage::class, $params, 'stage_id'),
        'joined_at' => new Carbon\Carbon(),
    ];
});

$factory->define(PlayerLeague::class, function (Faker\Generator $faker, $params = []) {
    return [
        'player_id' => newModel(User::class, $params, 'player_id'),
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
    ];
});


$factory->define(PlayerBasketballStat::class, function (Faker\Generator $faker, $params = []) {
    return [
        'player_id' => newModel(User::class, $params, 'player_id'),
        'team_id' => newModel(Team::class, $params, 'team_id'),
        'game_id' => newModel(Game::class, $params, 'game_id'),
        'jersey' => $faker->numberBetween(1,30) . ' ' . $faker->firstName,
        'minutes_played' => $faker->time(),
        'points' => $faker->numberBetween(5,30),
        'field_goals_made' => $faker->numberBetween(5,30),
        'field_goals_attempted' => $faker->numberBetween(5,30),
        '3_points_shots_made' => $faker->numberBetween(5,30),
        '3_points_shots_attempted' => $faker->numberBetween(5,30),
        'free_throws_made' => $faker->numberBetween(5,30),
        'free_throws_attempted' => $faker->numberBetween(5,30),
        'offensive_rebounds' => $faker->numberBetween(5,30),
        'defensive_rebounds' => $faker->numberBetween(5,30),
        'assists' => $faker->numberBetween(5,30),
        'turnovers' => $faker->numberBetween(5,30),
        'steals' => $faker->numberBetween(5,30),
        'blocked_shots' => $faker->numberBetween(5,30),
        'personal_fouls' => $faker->numberBetween(5,30),
    ];
});

$factory->define(Division::class, function (Faker\Generator $faker, $params = []) {
    return [
        'name' => $faker->name,
        'stage_id' => newModel(RegularStage::class, $params, 'stage_id'),
        'stage_type' => RegularStage::class,
    ];
});

$factory->define(FollowLeague::class, function (Faker\Generator $faker, $params = []) {
    return [
        'user_id' => newModel(User::class, $params, 'user_id'),
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'status' => FollowLeague::FOLLOWING,
    ];
});

$factory->define(GameStructure::class, function (Faker\Generator $faker, $params = []) {
    return [
        'name' => $faker->name,
        'name_localized' => $faker->name,
    ];
});

$factory->define(Notification::class, function (Faker\Generator $faker, $params = []) {
    return [
        'title' => $faker->text,
        'text' => $faker->text,
        'consumed' => false,
        'event_type' => Notification::TYPE_BASIC_NOTIFICATION,
        'image_id' => newModel(Image::class, $params, 'image_id'),
        'user_id' => newModel(User::class, $params, 'user_id'),
    ];
});

$factory->define(LeagueReview::class, function (Faker\Generator $faker, $params = []) {
    return [
        'review' => $faker->text,
        'verified' => true,
        'stars' => $faker->numberBetween(1,5),
        'reviewer_id' => newModel(User::class, $params, 'user_id'),
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
    ];
});

$factory->define(TeamSoccerStat::class, function (Faker\Generator $faker, $params = []) {
    return [
        'game_id' => newModel(Game::class, $params, 'game_id'),
        'home_team_red_cards' => $faker->numberBetween(0,4),
    ];
});

$factory->define(TeamBasketballStat::class, function (Faker\Generator $faker, $params = []) {
    return [
        'team_id' => newModel(Team::class, $params, 'team_id'),
        'game_id' => newModel(Game::class, $params, 'game_id'),
        'first_quarter_score' => $faker->numberBetween(1,5),
        'second_quarter_score' => $faker->numberBetween(1,5),
        'third_quarter_score' => $faker->numberBetween(1,5),
        'fourth_quarter_score' => $faker->numberBetween(1,5),
        'final_score' => $faker->numberBetween(20,30),
        'win' => 0,
        'loss' => 0,
        'draw' => 1,
    ];
});

$factory->define(TeamFootballStat::class, function (Faker\Generator $faker, $params = []) {
    return [
    ];
});

$factory->define(TeamHockeyStat::class, function (Faker\Generator $faker, $params = []) {
    return [
    ];
});

$factory->define(BasketballRules::class, function (Faker\Generator $faker, $params = []) {
    return [
        'times' => $faker->numberBetween(2,4),
        'minutes_per_time' => $faker->numberBetween(10,45),
        'points_per_win' => $faker->numberBetween(2,3),
        'points_per_loss' => 0,
        'points_per_draw' => 1,
    ];
});

$factory->define(CompetitionWeek::class, function (Faker\Generator $faker, $params = []) {
    return [
        'stage_id' => newModel(RegularStage::class, $params, 'stage_id'),
        'stage_type' => RegularStage::class,
        'name' => $faker->firstName,
        'starts_at' => $faker->date(),
        'ends_at' => $faker->date(),
    ];
});

$factory->define(Weekday::class, function (Faker\Generator $faker, $params = []) {
    return [
        'day' => $faker->dayOfWeek,
        'day_localized' => $faker->slug(1),
    ];
});

$factory->define(RegularStage::class, function (Faker\Generator $faker, $params = []) {
    return [
        'competition_id' => newModel(SeasonCompetition::class, $params, 'competition_id'),
        'competition_type' => SeasonCompetition::class,
        'rule_id' => newModel(BasketballRules::class, $params, 'competition_id'),
        'rule_type' => BasketballRules::class,
        'starts_at' => $faker->date(),
        'ends_at' => $faker->date(),
    ];
});

$factory->define(LeaguePermission::class, function (Faker\Generator $faker, $params = []) {
    return [
        'league_id' => newModel(LeagueOrganization::class, $params, 'league_id'),
        'type' => LeaguePermission::TYPE_LIKE,
        'permission' => LeaguePermission::PERMISSION_EVERYBODY
    ];
});

$factory->define(Like::class, function (Faker\Generator $faker, $params = []) {
    return [
        'user_id' => newModel(User::class, $params, 'user_id'),
        'liked_item_id' => newModel(Image::class, $params, 'liked_item_id'),
        'liked_item_type' => Image::class,
        'liked' => true
    ];
});

$factory->define(Comment::class, function (Faker\Generator $faker, $params = []) {
    return [
        'user_id' => newModel(User::class, $params, 'user_id'),
        'commented_item_id' => newModel(Image::class, $params, 'commented_item_id'),
        'commented_item_type' => Image::class,
        'comment' => $faker->paragraph
    ];
});

$factory->define(Game::class, function (Faker\Generator $faker, $params = []) {

    if (isset($params['time'])) {
        $time = new Carbon\Carbon($params['time']);
    } else {
        $time = Carbon\Carbon::now()->addMonth($faker->numberBetween(1,4))->addWeek($faker->numberBetween(1,20))->addDay($faker->numberBetween(1,30));
    }

    return [
        'stage_id' => newModel(RegularStage::class, $params, 'home_team_id'),
        'stage_type' => RegularStage::class,
        'home_team_id' => newModel(Team::class, $params, 'home_team_id'),
        'visiting_team_id' => newModel(Team::class, $params, 'visiting_team_id'),
        'game_venue_id' => newModel(GameVenue::class, $params, 'game_venue_id'),
        'sport_id' => newModel(Sport::class, $params, 'sport_id'),
        'time' => $time,
        'competition_week_id' => newModel(CompetitionWeek::class, $params, 'competition_week_id', ['starts_at' => $time->startOfWeek(), 'ends_at' => $time->endOfWeek()]),
    ];
});