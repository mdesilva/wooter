<?php

namespace Wooter\Commands\Team;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\DeleteImageCommand;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteTeamCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $team_id
     */
    public function __construct($user_id, $team_id)
    {
        $this->teamId = $team_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param TeamRepository $teamRepository
     *
     * @param UserRepository $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws TeamNotFound
     * @throws UserHasNoOrganization
     * @throws UserNotFound
     */
    public function handle(TeamRepository $teamRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->isOrganization()) {
            throw new UserHasNoOrganization;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        if ($team->cover_photo) {
            $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $team->cover_photo_id]);
        }

        if ($team->logo) {
            $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $team->logo_id]);
        }

        if ( ! $team->delete()) {
            throw new DatabaseException('Error when deleting the team');
        }

        return true;
    }
}
