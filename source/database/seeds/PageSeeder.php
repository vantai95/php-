<?php

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $page = [
          [
            'id' => 1,
            'name' => 'home',
            'url' => '/'
          ],
          [
            'id' => 2,
            'name' => 'service',
            'url' => '/services'
          ],
          [
            'id' => 3,
            'name' => 'promotion',
            'url' => '/promotions'
          ],
          [
            'id' => 4,
            'name' => 'event',
            'url' => '/events'
          ]
        ];
        Page::insert($page);
    }
}
