<?php

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sections = [
          [
            'id' => 1,
            'name' => 'Change Display Image',
            'page_id' => 1,
            'order' => 1,
            'template' => 'user.home.sections.title.title',
          ],
          [
            'id' => 2,
            'name' => 'Combo',
            'page_id' => 1,
            'order' => 2,
            'template' => 'user.home.sections.combo.combo',
          ],
          [
            'id' => 3,
            'name' => 'Why Choose Us',
            'page_id' => 1,
            'order' => 3,
            'template' => 'user.home.sections.why_choose_us.why_choose_us',
          ],
          [
            'id' => 4,
            'name' => 'About us',
            'page_id' => 1,
            'order' => 4,
            'template' => 'user.home.sections.about_us.about_us',
          ],
          [
            'id' => 5,
            'name' => 'Welcome to our naturally effective',
            'page_id' => 1,
            'order' => 4,
            'template' => 'user.home.sections.welcome.welcome',
          ],
          [
            'id' => 6,
            'name' => 'Related news',
            'page_id' => 1,
            'order' => 5,
            'template' => 'user.home.sections.related_news.related_news',
          ],
          [
            'id' => 7,
            'name' => 'Custom Quote',
            'page_id' => 1,
            'order' => 6,
            'template' => 'user.home.sections.custom_quote.custom_quote',
          ],
          [
            'id' => 8,
            'name' => 'Top',
            'page_id' => 2,
            'order' => 1,
            'template' => 'user.services.list.sections.top.top',
          ],
          [
            'id' => 9,
            'name' => 'Body',
            'page_id' => 2,
            'order' => 2,
            'template' => 'user.services.list.sections.body.body',
          ],
          [
            'id' => 10,
            'name' => 'Bottom',
            'page_id' => 2,
            'order' => 3,
            'template' => 'user.services.list.sections.bottom.bottom',
          ],
        ];
        PageSection::insert($sections);
    }
}
