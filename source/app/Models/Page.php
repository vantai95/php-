<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = 'pages';
    protected $fillable = ['name','url'];
    protected $primaryKey = 'id';

    public function sections(){
      return $this->hasMany('App\Models\PageSection','page_id');
    }
}
