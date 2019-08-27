<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            [
                'name_en' => 'Ha Noi',
                'name_vi' => 'Hà Nội',
            ],
            [
                'name_en' => 'Ho Chi Minh',
                'name_vi' => 'Hồ Chí Minh',
            ],
            [
                'name_en' => 'Đong Nai',
                'name_vi' => 'Đồng Nai',
            ]
        ];

        if(DB::table('provinces')->count() == 0){
            DB::table('provinces')->insert($provinces);
        }
    }
}
