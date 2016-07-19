<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeaguePasscode;
use Wooter\Wooter\Repositories\Organization\League\LeaguePasscodeRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePasscodeLength;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePasscodeAlreadyCreated;

class CreateLeaguePasscodeCommand extends Command implements SelfHandling
{

    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $passCode;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($league_id, $passcode )
    {
        $this->leagueId = $league_id;
        $this->passCode = $passcode;
    }

    /**
     * Execute Create command
     *
     * @param LeaguePasscodeRepository $leaguePasscodeRepository
     * @param LeagueRepository $leagueRepository
     * @return string
     * @throws LeagueNotFound
     */
    public function handle(LeaguePasscodeRepository $leaguePasscodeRepository, LeagueRepository $leagueRepository)
    {

        //check league
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }


        /**
         * Get passcode for league if its already generated.
         *
         * @var  $passCode */

        $passCode = $leaguePasscodeRepository->getPasscodeFromId($this->leagueId);

        // Return exception if passcode already created for the league.

        if($passCode)
        {
            throw new LeaguePasscodeAlreadyCreated();
        }

        //Check passcode length is less or greater than 6 characters
        //@Throw exception

        if (strlen($this->passCode) != 6)
        {
            throw new LeaguePasscodeLength();
        }

        //$passCode = LeaguePasscode::PASSCODE . substr(uniqid("", false), 9,13);


        $leaguePasscode = new LeaguePasscode();
        $leaguePasscode->league_id = $this->leagueId;
        $leaguePasscode->passcode = $this->passCode;


        $leaguePasscodeRepository->create($leaguePasscode);


        return $leaguePasscode;



    }
}
