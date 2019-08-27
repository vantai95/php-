<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'full_name' => 'admin',
                'role_id' => 1,
                'email' => 'admin@mailinator.com',
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        if(DB::table('users')->count() == 0){
            DB::table('users')->insert($users);
        }
    }
}

