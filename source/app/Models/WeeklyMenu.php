<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class WeeklyMenu extends Model
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
    protected $table = 'weekly_menus';

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
        'image',
        'from_date',
        'to_date',
    ];

    //check status of item
    public function status()
    {
        return $this->active ? WeeklyMenu::STATUS_FILTER['ACTIVE'] : WeeklyMenu::STATUS_FILTER['INACTIVE'];
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
        return url(config('constants.DEFAULT.WEEKLY_MENU_IMAGE'));
    }
}
