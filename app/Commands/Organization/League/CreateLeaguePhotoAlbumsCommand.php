<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeaguePhotoAlbum;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoAlbumRepository;

class CreateLeaguePhotoAlbumsCommand extends Command implements SelfHandling
{

    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $album_name;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $album_name
     * @param $user_id
     */
    public function __construct($league_id, $album_name, $user_id)
    {
        $this->leagueId = $league_id;
        $this->album_name = $album_name;
        $this->userId = $user_id;
    }


    /**
     * Execute the command.
     *
     * @param LeagueRepository           $leagueRepository
     * @param LeaguePhotoAlbumRepository $leaguePhotoAlbumRepository
     *
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeaguePhotoAlbumRepository $leaguePhotoAlbumRepository)
    {
        //check league
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $leaguePhotoAlbum = new LeaguePhotoAlbum();
        $leaguePhotoAlbum->album_name = $this->album_name;
        $leaguePhotoAlbum->league_id = $this->leagueId;

        $leaguePhotoAlbumRepository->create($leaguePhotoAlbum);

    }
}
