<?php

namespace Wooter\Commands\Team;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\Commands\DeleteImageCommand;
use Wooter\Commands\UpdateImageCommand;
use Wooter\Team;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\User\UserHasNoOrganization;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdateTeamCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $captainId;
    /**
     * @var UploadedFile
     */
    private $coverPhoto;
    /**
     * @var UploadedFile
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
     * @var null
     */
    private $sportId;

    /**
     * Create a new command instance.
     *
     * @param              $user_id
     * @param              $team_id
     * @param              $name
     * @param              $cover_photo
     * @param              $logo
     * @param              $description
     * @param              $captain_id
     * @param null         $sport_id
     */
    public function __construct($user_id, $team_id, $name, $cover_photo = null, $logo = null, $description = null, $captain_id = null, $sport_id = null)
    {
        $this->teamId = $team_id;
        $this->name = $name;
        $this->captainId = $captain_id;
        $this->coverPhoto = $cover_photo;
        $this->logo = $logo;
        $this->description = $description;
        $this->userId = $user_id;
        $this->sportId = $sport_id;
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
     * @return
     * @throws TeamNotFound
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

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        $team = DB::transaction(function () use ($team, $teamRepository, $imageRepository) {

            if ($this->coverPhoto instanceof UploadedFile) {
                if ($team->cover_photo) {
                    $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $team->cover_photo_id]);
                }
                $coverPhoto = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->coverPhoto, 'prefix' => Team::COVER_PHOTO_PREFIX, 'description' => Team::COVER_PHOTO_DESCRIPTION]);
                $team->cover_photo_id = $coverPhoto->id;
            }

            if ($this->logo instanceof UploadedFile) {
                if ($team->logo) {
                    $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $team->logo_id]);
                }
                $logo = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->logo, 'prefix' => Team::LOGO_PREFIX, 'description' => Team::LOGO_DESCRIPTION]);
                $team->logo_id = $logo->id;
            }

            $team->name = $this->name;

            if ($this->captainId) {
                $team->captain_id = $this->captainId;
            }

            if ($this->sportId) {
                $team->sport_id = $this->sportId;
            }

            if ($this->description) {
                $team->description = $this->description;
            }

            $teamRepository->update($team);

            return $team;
        });

        return $team->fresh();
    }
}
