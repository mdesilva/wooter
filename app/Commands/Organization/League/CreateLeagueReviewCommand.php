<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueReview;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueReviewRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueReviewCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $review;
    /**
     * @var
     */
    private $stars;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     * @param $review
     * @param $stars
     */
    public function __construct($league_id, $user_id, $review, $stars=null)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->review = $review;
        $this->stars = $stars;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository       $leagueRepository
     * @param UserRepository         $userRepository
     * @param LeagueReviewRepository $leagueReviewRepository
     *
     * @return LeagueReview
     * @throws LeagueNotFound
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository, LeagueReviewRepository $leagueReviewRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $leagueReview = new LeagueReview;
        $leagueReview->league_id = $this->leagueId;
        $leagueReview->reviewer_id = $this->userId;
        $leagueReview->verified = false;
        $leagueReview->review = $this->review;
        $leagueReview->stars = $this->stars;

        $leagueReviewRepository->create($leagueReview);

        return $leagueReview;
    }
}
