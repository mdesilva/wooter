<?php

namespace Wooter\Commands\Payment;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Competition\Season\SeasonCompetitionNotFound;
use Wooter\Wooter\Exceptions\Payment\PaymentMethodNotFound;
use Wooter\Wooter\Exceptions\Payment\PaymentNotFound;
use Wooter\Wooter\Exceptions\User\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueSeasonRepository;
use Wooter\Wooter\Repositories\Payment\PaymentMethodRepository;
use Wooter\Wooter\Repositories\Payment\PaymentRepository;
use Wooter\Wooter\Repositories\User\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePaymentCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $paymentMethodId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $amount;
    /**
     * @var
     */
    private $leagueSeasonId;
    /**
     * @var
     */
    private $paymentId;

    /**
     * Create a new command instance.
     * @param $payment_id
     * @param $payment_method_id
     * @param $user_id
     * @param $team_id
     * @param $league_id
     * @param $league_season_id
     * @param $amount
     */
    public function __construct($payment_id, $payment_method_id, $user_id, $team_id, $league_id, $league_season_id, $amount)
    {
        $this->paymentMethodId = $payment_method_id;
        $this->userId = $user_id;
        $this->teamId = $team_id;
        $this->leagueId = $league_id;
        $this->amount = $amount;
        $this->leagueSeasonId = $league_season_id;
        $this->paymentId = $payment_id;
    }

    /**
     * Execute the command.
     *
     * @param PaymentRepository $paymentRepository
     * @param UserRepository $userRepository
     * @param LeagueRepository $leagueRepository
     * @param PaymentMethodRepository $paymentMethodRepository
     * @param TeamRepository $teamRepository
     * @param LeagueSeasonRepository $leagueSeasonRepository
     * @throws LeagueNotFound
     * @throws SeasonCompetitionNotFound
     * @throws PaymentMethodNotFound
     * @throws PaymentNotFound
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(PaymentRepository $paymentRepository, UserRepository $userRepository, LeagueRepository $leagueRepository,
                           PaymentMethodRepository $paymentMethodRepository, TeamRepository $teamRepository, LeagueSeasonRepository $leagueSeasonRepository)
    {
        $payment = $paymentRepository->getById($this->paymentId);

        if ( ! $payment)
        {
            throw new PaymentNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound();
        }

        $paymentMethod = $paymentMethodRepository->getById($this->paymentMethodId);

        if ( ! $paymentMethod)
        {
            throw new PaymentMethodNotFound;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team)
        {
            throw new TeamNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $leagueSeason = $leagueSeasonRepository->getById($this->leagueSeasonId);

        if ( ! $leagueSeason)
        {
            throw new SeasonCompetitionNotFound;
        }

        if ($league->season->id !== $leagueSeason->id)
        {
            throw new SeasonCompetitionNotFound;
        }

        $payment->user_id = $this->userId;
        $payment->payment_method_id = $this->paymentMethodId;
        $payment->team_id = $this->teamId;
        $payment->league_id = $this->leagueId;
        $payment->season_id = $this->leagueSeasonId;
        $payment->amount = $this->amount;

        $paymentRepository->create($payment);

        return $payment;
    }
}
