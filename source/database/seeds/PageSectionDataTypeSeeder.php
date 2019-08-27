<?php

use Illuminate\Database\Seeder;
use App\Models\PageSectionDataType;

class PageSectionDataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sectionTypes = [
          [
            'id' => 1,
            'name' => 'slider',
            'accepted_data' => 'json_array',
            'template' => 'slider',
          ],
          [
            'id' => 2,
            'name' => 'cover_image',
            'accepted_data' => 'images',
            'template' => 'cover_image'
          ],
          [
            'id' => 3,
            'name' => 'text_only',
            'accepted_data' => 'text',
            'template' => ''
          ],
          [
            'id' => 4,
            'name' => 'customize',
            'accepted_data' => '',
            'template' => ''
          ]
        ];
        PageSectionDataType::insert($sectionTypes);
    }
}
