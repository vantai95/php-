<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NewsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $news_types = [
            [
                'active' => true,
                'name_en' => 'Skin care',
                'name_vi' => 'Chăm sóc da',
                'slug' => 'news-skin-care'
            ],
            [
                'active' => true,
                'name_en' => 'Body',
                'name_vi' => 'Chăm sóc toàn thân',
                'slug' => 'news-body'
            ]
        ];

        if(DB::table('news_types')->count() == 0){
            DB::table('news_types')->insert($news_types);
        }
    }
}
