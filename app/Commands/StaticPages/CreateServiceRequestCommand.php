<?php

namespace Wooter\Commands\StaticPages;

use Illuminate\Contracts\Mail\Mailer;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\ServiceRequest;
use Wooter\Wooter\Repositories\StaticPages\ServiceRequestRepository;

class CreateServiceRequestCommand extends Command implements SelfHandling
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
    private $type;
    /**
     * @var
     */
    private $address_1;
    /**
     * @var
     */
    private $address_2;
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
     * Create a new command instance.
     *
     * @param $email
     * @param $phone
     * @param $name
     * @param $type
     * @param $sport
     * @param $address_1
     * @param $address_2
     * @param $number_of_players
     * @param $number_of_teams
     * @param $number_of_games_per_team
     */
    public function __construct($email, $phone, $name, $type, $sport, $address_1=null, $address_2=null, $number_of_players=null, $number_of_teams=null, $number_of_games_per_team=null)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->name = $name;
        $this->type = $type;
        $this->address_1 = $address_1;
        $this->address_2 = $address_2;
        $this->numberOfPlayers = $number_of_players;
        $this->numberOfTeams = $number_of_teams;
        $this->numberOfGamesPerTeam = $number_of_games_per_team;
        $this->sport = $sport;
    }

    /**
     * Execute the command.
     *
     * @param ServiceRequestRepository $serviceRequestRepository
     *
     * @param Mailer                   $mailer
     *
     * @return ServiceRequest
     */
    public function handle(ServiceRequestRepository $serviceRequestRepository, Mailer $mailer)
    {
        $serviceRequest = new ServiceRequest;

        $serviceRequest->email = $email = $this->email;
        $serviceRequest->phone = $this->phone;
        $serviceRequest->name = $this->name;
        $serviceRequest->type = $this->type;
        $serviceRequest->sport = $this->sport;
        $serviceRequest->address_1 = $this->address_1;
        $serviceRequest->address_2 = $this->address_2;
        $serviceRequest->number_of_players = $this->numberOfPlayers;
        $serviceRequest->number_of_teams = $this->numberOfTeams;
        $serviceRequest->number_of_games_per_team = $this->numberOfGamesPerTeam;

        $serviceRequestRepository->create($serviceRequest);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'type_name' => ServiceRequest::$types[$this->type]
        ];

        $mailer->send('emails.service_request.inform_user', $data, function ($mail) use ($email) {
            $mail->to($email);
        });

        $mailer->send('emails.service_request.inform_admin', $data, function ($mail) {
            $mail->to('vip@wooter.co');
        });

        return $serviceRequest;
    }
}
