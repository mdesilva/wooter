<?php

namespace Wooter\Commands\Organization;

use Illuminate\Support\Collection;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueBasicsTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueDetailsTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueGameVenueTransformer;
// use Wooter\Wooter\Transformers\Organization\League\LeagueLocationTransformer;
use Wooter\Wooter\Transformers\LocationTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeaguePhotoTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueSeasonsTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueTagPhotoTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueTransformer;
use Wooter\Wooter\Transformers\Organization\League\LeagueVideoTransformer;
use Wooter\Wooter\Transformers\Qnap\QnapLeagueVideoTransformer;
use Wooter\Wooter\Transformers\Team\DivisionTransformer;

class ReadLeaguesByOrganizationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $user;
    private $transformer;

    /**
     * ReadLeaguesByOrganizationCommand constructor.
     * @param User $user
     */
    public function __construct(User $user) {

        $this->user = $user;
        $this->transformer =    new LeagueTransformer(
                                    new LeagueBasicsTransformer(),
                                    new LeagueDetailsTransformer(),
                                    new LeaguePhotoTransformer(new ImageTransformer(), new LeagueTagPhotoTransformer()),
                                    new LeagueVideoTransformer(new LeagueTagPhotoTransformer()),
                                    new LocationTransformer(),
                                    new LeagueGameVenueTransformer(),
                                    new LeagueSeasonsTransformer(),
                                    new QnapLeagueVideoTransformer(new LeagueTagPhotoTransformer()),
                                    new DivisionTransformer()
                                );
    }

    /**
     * @return static
     */
    public function handle() {
        $leagues = $this->user->organization()->first()->leagues()->get();
        $collection = Collection::make();

        foreach ($leagues as $league){
            $collection->push($this->transformer->transform($league));
        }

        return $collection;
    }
}
