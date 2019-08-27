<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class GalleryType extends Model
{
    use Sluggable;

    const STATUS_TEXT = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallery_types';

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
    protected $fillable = ['active',
        'name_en',
        'name_vi',
        'name_ja',
        'slug',
        'code'];

    /**
     * Get the users of role.
     */
    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery', 'gallery_type_id');
    }

    public function canDelete()
    {
        if (count($this->galleries) > 0) {
            return false;
        } else {
            if (empty($this->code)) {
                return true;
            }
            return false;
        }
    }

    public function status()
    {
        return $this->active ? __('admin.gallery_types.status.active') : __('admin.gallery_types.status.inactive');
    }

    public function status_class()
    {
        return $this->active ? 'm-badge--success' : 'm-badge--metal';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ],
            'code' => [
                'source' => 'name_en'
            ]
        ];
    }
}
