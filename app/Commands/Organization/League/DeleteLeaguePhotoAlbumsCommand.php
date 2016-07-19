<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoAlbumRepository;
use Wooter\Wooter\Exceptions\DatabaseException;

class DeleteLeaguePhotoAlbumsCommand extends Command implements SelfHandling
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
     * @var
     */
    private $album_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($league_id,  $album_id)
    {
        $this->leagueId = $league_id;
        $this->album_id = $album_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueRepository $leagueRepository, LeaguePhotoAlbumRepository $leaguePhotoAlbumRepository)
    {
        //check league
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }

        $albumModel = $leaguePhotoAlbumRepository->getById($this->album_id);


        if ( ! $albumModel->delete())
        {

            throw new DatabaseException('There was an error deleting the league basics');
        }
    }
}
