<?php

namespace Wooter\Commands\Organization;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\OrganizationAddress;
use Wooter\Wooter\Repositories\Organization\OrganizationAddressRepository;

class CreateOrganizationAddressCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $organizationId;
    /**
     * @var
     */
    private $countryId;
    /**
     * @var
     */
    private $street;
    /**
     * @var
     */
    private $flat;
    /**
     * @var
     */
    private $city;
    /**
     * @var
     */
    private $zip;
    /**
     * @var
     */
    private $state;
    /**
     * @var
     */
    private $fullAddress;
    /**
     * @var
     */
    private $x;
    /**
     * @var
     */
    private $y;

    /**
     * Create a new command instance.
     *
     * @param $organization_id
     * @param $country_id
     * @param $street
     * @param $flat
     * @param $city
     * @param $zip
     * @param $state
     * @param $full_address
     * @param $x
     * @param $y
     */
    public function __construct($organization_id, $country_id, $street, $flat, $city, $zip, $state, $full_address, $x, $y)
    {
        $this->organizationId = $organization_id;
        $this->countryId = $country_id;
        $this->street = $street;
        $this->flat = $flat;
        $this->city = $city;
        $this->zip = $zip;
        $this->state = $state;
        $this->fullAddress = $full_address;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Execute the command.
     *
     * @param OrganizationAddressRepository $organizationAddressRepository
     * @return bool
     */
    public function handle(OrganizationAddressRepository $organizationAddressRepository)
    {
        $organizationAddress = new OrganizationAddress;

        $organizationAddress->organization_id = $this->organizationId;
        $organizationAddress->country_id = $this->countryId;
        $organizationAddress->street = $this->street;
        $organizationAddress->flat = $this->flat;
        $organizationAddress->city = $this->city;
        $organizationAddress->zip = $this->zip;
        $organizationAddress->state = $this->state;
        $organizationAddress->full_address = $this->fullAddress;
        $organizationAddress->x = $this->x;
        $organizationAddress->y = $this->y;

        return $organizationAddressRepository->save($organizationAddress);
    }
}
