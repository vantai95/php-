<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class EventType extends Model
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
    protected $table = 'event_types';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['active', 'name_en', 'name_vi', 'slug'];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function status()
    {
        if($this->active) {
            return __('admin.event_types.statuses.active');
        }
        return __('admin.event_types.statuses.inactive');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }
}
