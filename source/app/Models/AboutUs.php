<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;

class AboutUs extends Model
{
    public $timestamps = true;

    use Sluggable;

    const STATUS_FILTER = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'about_us';

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
    protected $fillable = [
        'active',
        'name_en',
        'name_vi',
        'name_ja',
        'slug',
        'description_en',
        'description_vi',
        'description_ja',
        'short_description_en',
        'short_description_vi',
        'short_description_ja',
        'image',
    ];

    //check status of item
    public function status()
    {
        return $this->active ? AboutUs::STATUS_FILTER['ACTIVE'] : AboutUs::STATUS_FILTER['INACTIVE'];
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
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.IMAGE_LIST') . '/' . $this->image);
        }
        return url(config('constants.DEFAULT.ABOUT_US_IMAGE'));
    }
}
