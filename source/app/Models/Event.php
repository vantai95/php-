<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;

class Event extends Model
{
    use Sluggable;

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

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
    protected $fillable = ['active','name_en', 'name_vi', 'slug',
    'short_description_en','short_description_vi', 'description_en',
     'description_vi', 'image', 'video', 'event_type_id', 'location','timeline','date_begin'];

          
    public function status()
    {
        if($this->active) {
            return __('admin.events.statuses.active');
        }
        return __('admin.events.statuses.inactive');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.IMAGE_LIST') . '/' . $this->image);
        }
        return asset(config('constants.DEFAULT.IMAGE_LIST'));
    }
}
