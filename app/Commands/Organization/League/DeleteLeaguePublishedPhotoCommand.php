<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\ImageRepository;

class DeleteLeaguePublishedPhotoCommand extends Command implements SelfHandling
{
    /**
     * @var array
     */
    private $photos = array();

    /**
     * @var
     */
    private $user_id;

    /**
     * @param $user_id
     * @param $photos
     */
    public function __construct($user_id, $photos)
    {
        $this->photos = $photos;
        $this->user_id = $user_id;
    }


    /**
     * @param LeaguePhotoRepository $leaguePhotoRepository
     * @param ImageRepository $imageRepository
     * @return bool
     * @throws LeagueNotBelongToUser
     * @throws LeaguePhotoNotFound
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository, ImageRepository $imageRepository)
    {
        foreach($this->photos as $photoParam)
        {

            $leaguePhoto = $leaguePhotoRepository->getById($photoParam["photoId"]);

                if ( ! $leaguePhoto)
                {
                    throw new LeaguePhotoNotFound;
                }

                if ($leaguePhoto->league->organization->user->id !== $this->user_id) {
                    throw new LeagueNotBelongToUser;
                }

            $image = $imageRepository->getById($leaguePhoto->image_id);

            if(file_exists($image->thumbnail_path))
            {
                unlink($image->thumbnail_path);
            }


            if(file_exists($image->file_path))
            {
                unlink($image->file_path);
            }



            // removing the photo being deleted from their corresponding tables.
            $leaguePhoto->player_photos()->detach();
            $leaguePhoto->team_photos()->detach();

            $leaguePhoto->delete();
            $image->delete();




        }



        return true;
    }
}
