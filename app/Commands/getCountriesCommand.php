<?php

namespace Wooter\Commands;

use Illuminate\Support\Facades\Request;
use Ixudra\Curl\Facades\Curl;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Exception;

class getCountriesCommand extends Command implements SelfHandling
{

    use DispatchesJobs;

    /**
     * @var string
     */
    private $apiURL = 'https://restcountries.eu/rest/v1/all';

    /**
     * Create a new command instance.
     * getCountriesCommand constructor.
     */
    public function __construct(){

    }

    /**
     *  Execute the command.
     * @return mixed
     */
    public function handle(){
        $result = [];
        $countries = [];
        $response = Curl::to($this->apiURL)->asJson()->get();

        if (is_array($response)) {

            foreach ($response as $country){
                $countries[] = $country->name.'|'.$country->alpha2Code;
            }

            asort($countries);

            $result = [];
            foreach ($countries as $countryAndCode){
                $countryAndCodeArray = explode('|', $countryAndCode);
                $result[] = [
                    "name" => $countryAndCodeArray[0],
                    "code" => $countryAndCodeArray[1]
                ];
            }
        }

        return $result;
    }
}
