<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSectionDataType extends Model
{
    //
    protected $talbe = 'page_section_data_types';
    protected $primaryKey = 'id';
    protected $fillable = ['name','accepted_data','template'];


}
