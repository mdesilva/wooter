<?php

namespace Wooter\Commands\User;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Commands\CreateImageCommand;
use Wooter\Commands\DeleteImageCommand;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateUserPhotoCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $fromCreate;
    /** Vars for league publish photo functions */
    /**
     * @var array
     */
    private $photo;

    /**
     * CreateLeaguePhotoCommand constructor.
     *
     * @param      $user_id
     * @param      $photo
     * @param bool $fromCreate
     * @param null $photo
     */
    public function __construct($user_id, $photo = null,$fromCreate = false)
    {
        $this->userId = $user_id;
        $this->photo = $photo;
        $this->fromCreate = $fromCreate;
    }

    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ($this->photo instanceof UploadedFile) {
            $this->dispatchFromArray(DeleteImageCommand::class, ['image_id' => $user->picture_id]);
            $image = $this->dispatchFromArray(CreateImageCommand::class, ['image' => $this->photo, 'user_id' => $this->userId, 'description' => null, 'prefix' => 'user_photo', 'fromCreate' => $this->fromCreate]);

            $user->picture_id = $image->id;

            $userRepository->update($user);
        }

        return $user;
    }
}
