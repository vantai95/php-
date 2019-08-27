<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class SubCategory extends Model
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
    protected $table = 'sub_categories';

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
    protected $fillable = ['active', 'category_id', 'sequence', 'name_en', 'name_vi', 'name_ja', 'slug', 'description_en', 'description_vi', 'description_ja', 'parent_id'];

    /**
     * Get the users of role.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'categories_items', 'sub_sub_category_id', 'item_id');
    }

    public function subSubCategories()
    {
        return $this->hasMany('App\Models\SubCategory', 'parent_id');
    }

    public function status()
    {
        if ($this->active) {
            return __('admin.sub_categories.statuses.active');
        }
        return __('admin.sub_categories.statuses.inactive');
    }

    public function status_class()
    {
        if ($this->active) {
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
