<?php

namespace Wooter\Commands\Organization;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;

class ArchiveLeaguesByOrganizationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $id;
    private $user;

    /**
     * ReadLeaguesByOrganizationCommand constructor.
     *
     * @param User $user
     * @param      $id
     */
    public function __construct(User $user, $id) {
        $this->user = $user;
        $this->id = $id;
    }

    /**
     * @return mixed
     * @throws LeagueNotFound
     */
    public function handle() {
        $leagues = $this->user->organization()->first()->leagues();
        $league = $leagues->find($this->id);
        $name = '';

        if (is_null($league)) {
            throw new LeagueNotFound();
        } else {
            $name = $league->name;
            
            $league->archive = 1;
            $league->save();
        }

        return [
            'state' => true,
            'name' => $name
        ];
    }
}
