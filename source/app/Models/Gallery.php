<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Gallery extends Model
{

    const STATUS_TEXT = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries';

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
        'images',
        'gallery_type_id'];

    /**
     * Get the users of role.
     */
    public function galleryTypes()
    {
        return $this->belongsTo('App\Models\GalleryType','gallery_type_id');
    }

    public function status()
    {
        return $this->active ? __('admin.galleries.status.active') : __('admin.galleries.status.inactive');
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
            ]
        ];
    }

    //Get item image URL
    public function imageUrl()
    {
      $imgList = json_decode($this->images);
        if(!empty($imgList)){
          return $imgList[0];
        }
        return url(config('constants.DEFAULT.IMAGE_LIST'));
    }
}
