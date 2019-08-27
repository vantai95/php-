<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    function run()
    {
		$this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
