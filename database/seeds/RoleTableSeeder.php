<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


/**
 * Class RoleTableSeeder.
 */
class RoleTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        $admin = Role::create(['name' => config('access.users.admin_role')]);
        $user = Role::create(['name' => config('access.users.default_role')]);

    }
}
