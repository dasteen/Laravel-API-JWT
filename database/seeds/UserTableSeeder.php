<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        //Add the master administrator, user id of 1
        $users = [
            [
                'name'              => 'admin',
                'email'             => 'admin@admin.com',
                'password'          => bcrypt('123456'),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'user',
                'email'             => 'user@user.com',
                'password'          => bcrypt('123456'),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);

    }
}
