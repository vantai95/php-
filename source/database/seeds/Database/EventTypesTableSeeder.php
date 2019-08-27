<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_types = [
            [
                'active' => true,
                'name_en' => 'Skin Rejuvenation',
                'name_vi' => 'Trẻ Hóa Da',
                'slug' => 'event-skin-rejuvenation'
            ],
            [
                'active' => true,
                'name_en' => 'Slimming, losing weight',
                'name_vi' => 'Giảm béo, giảm cân',
                'slug' => 'event-slimming-losing-weight'
            ]
        ];

        if(DB::table('event_types')->count() == 0){
            DB::table('event_types')->insert($event_types);
        }
    }
}
