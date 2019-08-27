<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageStorage extends Model
{
    //
    protected $fillable = ['page_id','section_id','data','data_type','order'];
    const PAGE = [
      [
        'id' => 1,
        'name' => 'home'
        'url' => '/'
      ],
      [
        'id' => 2,
        'name' => 'serivce'
        'url' => '/services'
      ],
      [
        'id' => 3,
        'name' => 'promotion'
        'url' => '/promotions'
      ],
      [
        'id' => 4,
        'name' => 'event'
        'url' => '/events'
      ]
    ]

    const SECTION = [
      [
        'name' => 'title'
      ],
      [
        'name' => 'why_choose_us'
      ],
      [
        'name' => 'about_us'
      ],
      [
        'name' => 'news'
      ],
      [
        'name' => 'other'
      ]
    ];

    const SECTION_DATA_TYPE = [
      'json',
      'text'
    ];
}
