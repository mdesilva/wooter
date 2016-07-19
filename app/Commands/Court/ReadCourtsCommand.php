<?php

namespace Wooter\Commands\Court;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Court\CourtsRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Route;

class ReadCourtsCommand extends Command implements SelfHandling
{
    /**
    * @var
    */
    private $userId;
    
    /**
    * @var
    */
    private $distance;
    
    /**
    * @var
    */
    private $latitude;
    
    /**
    * @var
    */
    private $longitude;
    
    /*
     * @var
     */
    private $offset;
    
    /*
     * @var
     */
    private $limit;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($userId, $distance, $latitude, $longitude, $offset, $limit)
    {
        $this->userId = $userId;
        $this->distance = $distance;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, 
                           CourtsRepository $courtsRepository)
    {
        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound();
        }
   
        $courts = $courtsRepository->all();
        $courts = $courts->slice($this->offset, $this->limit);
        
        return $courts;

    }
}

