<?php

namespace Wooter\Commands\StaticPages;

use Illuminate\Contracts\Mail\Mailer;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PackageRequest;
use Wooter\ServiceRequest;
use Wooter\Wooter\Repositories\StaticPages\PackageRequestRepository;

class CreatePackageRequestCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $phone;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $numberOfPlayers;
    /**
     * @var
     */
    private $numberOfTeams;
    /**
     * @var
     */
    private $numberOfGamesPerTeam;
    /**
     * @var
     */
    private $sport;
    /**
     * @var
     */
    private $packageType;
    /**
     * @var
     */
    private $fullGameFootage;
    /**
     * @var
     */
    private $gameHighlights;
    /**
     * @var
     */
    private $statistics;
    /**
     * @var
     */
    private $proVideography;
    /**
     * @var
     */
    private $top_10;
    /**
     * @var
     */
    private $weeklyRecap;
    /**
     * @var
     */
    private $playerPhotos;
    /**
     * @var
     */
    private $teamPhotos;
    /**
     * @var
     */
    private $promoVideo;
    /**
     * @var
     */
    private $mediaCoverage;
    /**
     * @var
     */
    private $blogExposure;

    /**
     * Create a new command instance.
     *
     * @param $email
     * @param $phone
     * @param $name
     * @param $package_type
     * @param $sport
     * @param $number_of_players
     * @param $number_of_teams
     * @param $number_of_games_per_team
     * @param $full_game_footage
     * @param $game_highlights
     * @param $statistics
     * @param $pro_videography
     * @param $top_10
     * @param $weekly_recap
     * @param $player_photos
     * @param $team_photos
     * @param $promo_video
     * @param $media_coverage
     * @param $blog_exposure
     */
    public function __construct($email, $phone, $name, $package_type, $sport=null, $number_of_players=null, $number_of_teams=null, $number_of_games_per_team=null,
                                    $full_game_footage = false, $game_highlights = false, $statistics = false, $pro_videography = false, $top_10 = false, $weekly_recap = false, $player_photos = false,
                                    $team_photos = false, $promo_video = false, $media_coverage = false, $blog_exposure = false)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->name = $name;
        $this->numberOfPlayers = $number_of_players;
        $this->numberOfTeams = $number_of_teams;
        $this->numberOfGamesPerTeam = $number_of_games_per_team;
        $this->sport = $sport;
        $this->packageType = $package_type;
        $this->fullGameFootage = $full_game_footage;
        $this->gameHighlights = $game_highlights;
        $this->statistics = $statistics;
        $this->proVideography = $pro_videography;
        $this->top_10 = $top_10;
        $this->weeklyRecap = $weekly_recap;
        $this->playerPhotos = $player_photos;
        $this->teamPhotos = $team_photos;
        $this->promoVideo = $promo_video;
        $this->mediaCoverage = $media_coverage;
        $this->blogExposure = $blog_exposure;
    }

    /**
     * Execute the command.
     *
     * @param PackageRequestRepository $packageRequestRepository
     * @param Mailer                   $mailer
     *
     * @return ServiceRequest
     *
     */
    public function handle(PackageRequestRepository $packageRequestRepository, Mailer $mailer)
    {
        $packageRequest = new PackageRequest;

        $packageRequest->email = $email = $this->email;
        $packageRequest->phone = $this->phone;
        $packageRequest->name = $this->name;
        $packageRequest->package_type = $this->packageType;
        $packageRequest->sport = $this->sport;
        $packageRequest->number_of_players = $this->numberOfPlayers;
        $packageRequest->number_of_teams = $this->numberOfTeams;
        $packageRequest->number_of_games_per_team = $this->numberOfGamesPerTeam;
        $packageRequest->full_game_footage = $this->fullGameFootage;
        $packageRequest->game_highlights = $this->gameHighlights;
        $packageRequest->statistics = $this->statistics;
        $packageRequest->pro_videography = $this->proVideography;
        $packageRequest->top_10 = $this->top_10;
        $packageRequest->weekly_recap = $this->weeklyRecap;
        $packageRequest->player_photos = $this->playerPhotos;
        $packageRequest->team_photos = $this->teamPhotos;
        $packageRequest->promo_video = $this->promoVideo;
        $packageRequest->media_coverage = $this->mediaCoverage;
        $packageRequest->blog_exposure = $this->blogExposure;

        $packageRequestRepository->create($packageRequest);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'package_type' => ServiceRequest::$types[$this->packageType]
        ];

        $mailer->send('emails.package_request.inform_user', $data, function ($mail) use ($email) {
            $mail->to($email);
        });

        $mailer->send('emails.package_request.inform_admin', $data, function ($mail) {
            $mail->to('vip@wooter.co');
        });

        return $packageRequest;
    }
}
