<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;

class ReadPhotoMediaCommand extends Command implements SelfHandling
{
    private $photoId;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($photo_id)
    {
        $this->photoId = $photo_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository)
    {

        $photo = $leaguePhotoRepository->getByImageId($this->photoId);
        if ( ! $photo) {
            throw new LeaguePhotoNotFound;
        }
        return $photo;

    }
}
