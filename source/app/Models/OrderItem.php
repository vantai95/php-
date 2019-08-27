<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

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
        'order_id',
        'item_id',
        'price',
        'quantity'
    ];

    public function items(){
        return $this->hasMany('App\Models\Item', 'item_id');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
