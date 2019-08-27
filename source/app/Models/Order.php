<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;

    const ORDER_STATUS = [
        'PENDING' => 'Pending',
        'SUCCESS' => 'Success'
    ];

    const ORDER_TYPE = [
        '0' => 'Normal Item Order',
        '1' => 'Set Item Order',
        '2' => 'Weekly Item Order'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
        'name',
        'email',
        'address',
        'phone_number',
        'gender',
        'pax',
        'district',
        'payment_method_id',
        'datetime_delivery',
        'datetime_reservation',
        'dob',
        'status',
        'note',
        'sub_total',
        'discount',
        'tax',
        'total',
        'currency_id',
        'exchange_rate',
        'order_type'
    ];

    public function genderType()
    {
        return $this->gender ?  __('admin.orders.column.male') : __('admin.orders.column.female');
    }

    public function orderStatus()
    {
        return $this->status ?  __('admin.orders.status.done') : __('admin.orders.status.pending');;
    }

    public function items(){
        return $this->belongsToMany('App\Models\Item', 'order_items', 'order_id', 'item_id');
    }

    public function paymentMethod(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_method_id');
    }

}
