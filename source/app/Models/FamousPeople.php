<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;

class FamousPeople extends Model
{
    use Sluggable;
    public $timestamps = true;
    const STATUS_FILTER = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'famous_people';

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
    protected $fillable = [
        'name_vi', 'name_en', 'description_vi', 'description_en', 'image', 'video', 'active', 'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }

    public function status()
    {
        return $this->active ? FamousPeople::STATUS_FILTER['ACTIVE'] : FamousPeople::STATUS_FILTER['INACTIVE'];
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.IMAGE_LIST') . '/' . $this->image);
        }
        return asset(config('constants.DEFAULT.IMAGE_LIST'));
    }
}
