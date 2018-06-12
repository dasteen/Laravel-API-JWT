<?php

use Illuminate\Database\Seeder;
use App\User;

/**
 * Class UserRoleSeeder.
 */
class UserRoleSeeder extends Seeder
{

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        User::find(1)->assignRole(config('access.users.admin_role'));
        User::find(2)->assignRole(config('access.users.default_role'));

    }
}
