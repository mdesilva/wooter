<?php

namespace Wooter\Wooter\Traits\User;

use Wooter\Role;

trait UserRoleActions {

    /**
     * Helper function to guess whether a user is a Player or not
     */
    public function isPlayer()
    {
        return in_array(Role::PLAYER, $this->roles()->lists('id')->all());
    }

    /**
     * Helper function to guess whether a user is a Team Captain or not
     */
    public function isTeamCaptain()
    {
        return in_array(Role::TEAM_CAPTAIN, $this->roles()->lists('id')->all());
    }

    /**
     * Helper function to guess whether a user is an Organization or not
     */
    public function isOrganization()
    {
        return in_array(Role::ORGANIZATION, $this->roles()->lists('id')->all());
    }

    /**
     * Helper function to guess whether a user is an Organization Staff or not
     */
    public function isOrganizationStaff()
    {
        return in_array(Role::ORGANIZATION_STAFF, $this->roles()->lists('id')->all());
    }

    /**
     * Helper function to guess whether a user is an Admin or not
     */
    public function isAdmin()
    {
        return in_array(Role::ADMIN, $this->roles()->lists('id')->all());
    }

    /**
     * Helper function to guess whether a user is a Developer or not
     */
    public function isDeveloper()
    {
        return in_array(Role::DEVELOPER, $this->roles()->lists('id')->all());
    }

    /**
     * Makes the user a Team Captain
     */
    public function makeTeamCaptain()
    {
        $this->roles()->attach(Role::TEAM_CAPTAIN);

        $this->push();

        return $this;
    }

    /**
     * Makes the user the owner of an Organization
     */
    public function makeOrganization()
    {
        $this->roles()->attach(Role::ORGANIZATION);

        $this->push();

        return $this;
    }

    /**
     * Makes the user a Staff of an Organization
     */
    public function makeOrganizationStaff()
    {
        $this->roles()->attach(Role::ORGANIZATION_STAFF);

        $this->push();

        return $this;
    }

    /**
     * Makes the user an admin
     */
    public function makeAdmin()
    {
        $this->roles()->attach(Role::ADMIN);

        $this->push();

        return $this;
    }

    /**
     * Makes the user a developer
     */
    public function makeDeveloper()
    {
        $this->roles()->attach(Role::DEVELOPER);

        $this->push();

        return $this;
    }
}