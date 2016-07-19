<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePriceNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoAlbumRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePriceRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeaguePriceCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $leaguePriceId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $league_price_id
     */
    public function __construct($league_id, $league_price_id)
    {
        $this->leagueId = $league_id;
        $this->leaguePriceId = $league_price_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository      $leagueRepository
     * @param LeaguePriceRepository $leaguePriceRepository
     *
     * @throws LeagueNotFound
     * @throws LeaguePriceNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeaguePriceRepository $leaguePriceRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $leaguePrice = $leaguePriceRepository->getById($this->leaguePriceId);

        if ( ! $leaguePrice) {
            throw new LeaguePriceNotFound;
        }

        return $leaguePrice;
    }
}
