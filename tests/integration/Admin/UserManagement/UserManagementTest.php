<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Wooter\User;
use Illuminate\Support\Facades\Auth;

class UserManagementTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testing an admin can log as another user
     * @test
     * @return void
     */
    public function it_logs_an_admin_in_as_another_user()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
        $admin = $this->createAndLoginAnAdmin();

        $currentUserLogged = Auth::user();

        $this->assertSame($admin->id, $currentUserLogged->id);

        $user = factory(User::class)->create();

        $userIdToCheck = $user->id;
        $userEmailToCheck = $user->email;
        $userFirstNameToCheck = $user->first_name;
        $userLastNameToCheck = $user->last_name;

        $this->loginAsUser($user);

        $currentUserLogged = Auth::user();


        $this->assertSame($userIdToCheck, $currentUserLogged->id);
        $this->assertSame($userEmailToCheck, $currentUserLogged->email);
        $this->assertSame($userFirstNameToCheck, $currentUserLogged->first_name);
        $this->assertSame($userLastNameToCheck, $currentUserLogged->last_name);

    }

    /**
     * Testing a non-admin can not log as another user
     * @test
     * @return void
     */
    public function it_can_not_log_an_admin_in_as_another_user()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
        $this->markTestIncomplete('This test has not been implemented yet.');
        $basicUser = $this->createAndLoginABasicUser();

        $currentUserLogged = Auth::user();

        $this->assertSame($basicUser->id, $currentUserLogged->id);

        $user = factory(User::class)->create();

        $userIdToCheck = $user->id;
        $userEmailToCheck = $user->email;
        $userFirstNameToCheck = $user->first_name;
        $userLastNameToCheck = $user->last_name;

        $this->loginAsUser($user);

        $currentUserLogged = Auth::user();

        $this->assertNotSame($userIdToCheck, $currentUserLogged->id);
        $this->assertNotSame($userEmailToCheck, $currentUserLogged->email);
        $this->assertNotSame($userFirstNameToCheck, $currentUserLogged->first_name);
        $this->assertNotSame($userLastNameToCheck, $currentUserLogged->last_name);

        $this->assertSame($basicUser->id, $currentUserLogged->id);
        $this->assertSame($basicUser->email, $currentUserLogged->email);
        $this->assertSame($basicUser->first_name, $currentUserLogged->first_name);
        $this->assertSame($basicUser->last_name, $currentUserLogged->last_name);

    }

    private function loginAsUser($user)
    {
        $this->get('admin/user-management/login-as/' . $user->id, $this->headers);
    }

}
