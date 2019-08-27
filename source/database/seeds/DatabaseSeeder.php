<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    function run()
    {
        //$this->call(UsersTableSeeder::class);
		$this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(GalleryTypesTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        // $this->call(InitializationSeeder::class);
        $this->call(NewsTypesTableSeeder::class);
        $this->call(EventTypesTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
    }
}
