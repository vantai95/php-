<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Item extends Model
{
    public $timestamps = true;

    use Sluggable;

    const ITEM_STATUS = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];

    const ITEM_TYPE = [
        '0' => "Menu",
        '1' => "Set Menu",
        '2' => "Weekly Menu"
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';

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
        'thumb_image',
        'price',
        'discount_price',
        'item_type'
    ];


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'categories_items', 'item_id', 'category_id');
    }

    public function subCategories()
    {
        return $this->belongsToMany('App\Models\SubCategory', 'categories_items', 'item_id', 'sub_category_id')->withPivot('sub_sub_category_id');
    }

    //check status of item
    public function status()
    {
        return $this->active ? Item::ITEM_STATUS['ACTIVE'] : Item::ITEM_STATUS['INACTIVE'];
    }

    //check if item is set menu
    public function isSetItem()
    {
        return $this->item_type ? Item::ITEM_TYPE['1'] : '';
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
        return url(config('constants.DEFAULT.ITEM_IMAGE'));
    }

    public function subItems()
    {
        return $this->hasMany('App\Models\SubItem', 'main_item_id');
    }

    public function subItemsDetail()
    {
        return $this->belongsToMany('App\Models\Item', 'sub_items', 'main_item_id', 'item_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items', 'item_id', 'order_id');
    }
}
