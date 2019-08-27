<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name_en' => 'GLAMER CLINIC',
                'name_vi' => 'GLAMER CLINIC',
                'sequence' => 1,
                'active' => true,
                'url' => '/'
            ],
            [
                'name_en' => 'TREATMENT PACKAGE',
                'name_vi' => 'GÓI TRỊ LIỆU',
                'sequence' => 1,
                'active' => true,
                'url' => 'services'
            ],
            [
                'name_en' => 'PROMOTIONS',
                'name_vi' => 'ƯU ĐÃI',
                'sequence' => 1,
                'active' => true,
                'url' => 'promotions'
            ],
            [
                'name_en' => 'EVENTS',
                'name_vi' => 'SỰ KIỆN NỖI BẬT',
                'sequence' => 1,
                'active' => true,
                'url' => 'events'
            ]
        ];

        if(DB::table('menus')->count() == 0){
            DB::table('menus')->insert($menus);
        }

    }
}
