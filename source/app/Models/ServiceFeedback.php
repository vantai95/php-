<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;

class ServiceFeedback extends Model
{
  
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services_feedbacks';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['image', 'video', 'name_en', 'name_vi', 'description_en', 'description_vi'];

}
