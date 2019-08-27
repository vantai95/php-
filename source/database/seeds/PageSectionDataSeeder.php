<?php

use Illuminate\Database\Seeder;
use App\Models\PageSectionData;

class PageSectionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         $sectionDatas = [
          [
            'id' => 1,
            'name' => 'slider',
            'data_type_id' => 1,
            'data' => '[]',
            'client_template' => 'user.home.sections.title.data.slider',
            'section_id' => 1,
            'order' => 1
          ],
          [
            'id' => 2,
            'name' => 'top slider',
            'data_type_id' => 2,
            'data' => '',
            'client_template' => 'user.services.list.sections.top.data.top_img',
            'section_id' => 8,
            'order' => 1
          ],
          [
            'id' => 3,
            'name' => 'top slider',
            'data_type_id' => 4,
            'data' => '',
            'client_template' => 'user.services.list.sections.top.data.top_text',
            'section_id' => 8,
            'order' => 2
          ],
        ];
        PageSectionData::insert($sectionDatas);
    }
}
