<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sub_items';

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
    protected $fillable = ['main_item_id', 'item_id', 'sequence'];

    public function item()
    {
        return $this->belongsTo('App\Models\Item','main_item_id');
    }
}
