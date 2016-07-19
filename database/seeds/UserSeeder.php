<?php

use Illuminate\Database\Seeder;
use Wooter\LeagueOrganization;
use Wooter\Role;
use Wooter\User;
use Wooter\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carlos = factory(User::class)->create([
                'first_name' => 'Carlos',
                'last_name' => 'Morales Climent',
                'email' => 'carlos@wooter.co',
                'password' => bcrypt('carlos123'),
                'verified' => 1]
        );

        $userRole = new UserRole;
        $userRole->user_id = $carlos->id;
        $userRole->role_id = Role::ORGANIZATION;
        $userRole->save();

        $userRole = new UserRole;
        $userRole->user_id = $carlos->id;
        $userRole->role_id = Role::ADMIN;
        $userRole->save();

        $vip = factory(User::class)->create([
                'first_name' => 'Vip',
                'last_name' => 'Wooter',
                'email' => 'vip@wooter.co',
                'password' => bcrypt('Woozard0901'),
                'verified' => 1]
        );

        $userRole = new UserRole;
        $userRole->user_id = $vip->id;
        $userRole->role_id = Role::ORGANIZATION;
        $userRole->save();

        $userRole = new UserRole;
        $userRole->user_id = $vip->id;
        $userRole->role_id = Role::ADMIN;
        $userRole->save();

    }
}