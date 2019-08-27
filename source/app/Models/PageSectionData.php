<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSectionData extends Model
{
    //
    protected $table = "page_section_datas";
    protected $fillable = ['name','section_type_id','data','section_id'];
    protected $primaryKey = 'id';
}
