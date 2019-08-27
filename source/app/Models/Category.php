<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    const TYPE= [
        '0' => "Menu",
        '1' => "Set Menu",
        '2' => "Weekly Menu"
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
    protected $fillable = ['active', 'sequence', 'name_en', 'name_vi', 'name_ja', 'slug', 'description_en', 'description_vi', 'description_ja','type','image'];

    public function subCategories()
    {
        return $this->hasMany('App\Models\SubCategory');
    }

    public function canDelete()
    {
        return !count($this->subCategories) > 0;
    }

    public function services(){
      return $this->hasMany('App\Models\Service','category_id');
    }

    public function category_metas(){
      return $this->hasMany('App\Models\CategoryMeta','category_id');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'categories_items', 'category_id', 'item_id');
    }

    public function status()
    {
        if($this->active) {
            return __('admin.categories.statuses.active');
        }
        return __('admin.categories.statuses.inactive');
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
}
