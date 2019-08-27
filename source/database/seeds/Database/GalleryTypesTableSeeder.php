<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GalleryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $galleyTypes = [
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home Banner',
                'name_vi' => 'Home Banner',
                'code' => 'home-banner',
                'slug' => 'home-banner',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home Items',
                'name_vi' => 'Home Items',
                'code' => 'home-items',
                'slug' => 'home-items',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home About Us 1',
                'name_vi' => 'Home About Us 1',
                'code' => 'home-about-us-1',
                'slug' => 'home-about-us-1',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home About Us 2',
                'name_vi' => 'Home About Us 2',
                'code' => 'home-about-us-2',
                'slug' => 'home-about-us-2',
            ]
        ];

        if(DB::table('gallery_types')->count() == 0){
            DB::table('gallery_types')->insert($galleyTypes);
        }

        $galleries = [
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home Banner',
                'name_vi' => 'Home Banner',
                'gallery_type_id' => 1,
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home Items',
                'name_vi' => 'Home Items',
                'gallery_type_id' => 2,
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home About Us 1',
                'name_vi' => 'Home About Us 1',
                'gallery_type_id' => 3,
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'active' => true,
                'name_en' => 'Home About Us 2',
                'name_vi' => 'Home About Us 2',
                'gallery_type_id' => 4,
            ]
        ];

        if(DB::table('galleries')->count() == 0){
            DB::table('galleries')->insert($galleries);
        }
    }
}

