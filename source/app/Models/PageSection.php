<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    //
    protected $table = 'page_sections';
    protected $fillable = ['name','page_id','order'];
    protected $primaryKey = 'id';

    public function data(){
      return $this->hasMany('App\Models\PageSectionData','section_id');
    }
}
