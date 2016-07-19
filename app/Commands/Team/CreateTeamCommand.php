<?php

namespace Wooter\Commands\Team;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\Team;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateTeamCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $sportId;
    /**
     * @var
     */
    private $captainId;
    /**
     * @var
     */
    private $coverPhoto;
    /**
     * @var
     */
    private $logo;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param                   $user_id
     * @param                   $name
     * @param                   $sport_id
     * @param bool              $cover_photo
     * @param bool              $logo
     * @param                   $description
     * @param                   $captain_id
     */
    public function __construct($user_id, $name, $sport_id, $cover_photo = null, $logo = null, $description = null, $captain_id = null)
    {
        $this->name = $name;
        $this->sportId = $sport_id;
        $this->captainId = $captain_id;
        $this->coverPhoto = $cover_photo;
        $this->logo = $logo;
        $this->description = $description;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param TeamRepository  $teamRepository
     *
     * @param ImageRepository $imageRepository
     *
     * @param UserRepository  $userRepository
     *
     * @return Team
     * @throws UserHasNoOrganization
     * @throws UserNotFound
     */
    public function handle(TeamRepository $teamRepository, ImageRepository $imageRepository, UserRepository $userRepository)
    {

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->isOrganization()) {
            throw new UserHasNoOrganization;
        }

        $team = DB::transaction(function () use ($teamRepository, $imageRepository) {

            $team = new Team;

            if ($this->coverPhoto instanceof UploadedFile) {
                $coverPhoto = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->coverPhoto, 'description' => Team::COVER_PHOTO_DESCRIPTION, 'prefix' => Team::COVER_PHOTO_PREFIX]);
                $team->cover_photo_id = $coverPhoto->id;
            }

            if ($this->logo instanceof UploadedFile) {
                $logo = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->logo, 'description' => Team::LOGO_DESCRIPTION, 'prefix' => Team::LOGO_PREFIX]);
                $team->logo_id = $logo->id;
            }

            if ($this->captainId) {
                $team->captain_id = $this->captainId;
            }

            if ($this->description) {
                $team->description = $this->description;
            }

            $team->name = $this->name;
            $team->sport_id = $this->sportId;

            $teamRepository->create($team);

            return $team;
        });

        return $team;
    }
}
