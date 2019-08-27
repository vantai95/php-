<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMeta extends Model
{
    //
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_meta';

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
        'category_id',
        'name_en',
        'name_vi'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
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
