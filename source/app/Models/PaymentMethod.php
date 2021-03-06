<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PaymentMethod extends Model
{

    const STATUS_TEXT = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive'
    ];
    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

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
    protected $fillable = ['active',
        'name_en',
        'name_vi',
        'name_ja',
        'description_en',
        'description_vi',
        'description_ja'];


    public function canDelete()
    {
        if (count($this->payment_methods) > 0) {
            return false;
        } else {
            if (empty($this->name_en)) {
                return true;
            }
            return false;
        }
    }

    public function status()
    {
        return $this->active ? __('admin.payment_methods.status.active') : __('admin.payment_methods.status.inactive');
    }

    public function status_class()
    {
        return $this->active ? 'm-badge--success' : 'm-badge--metal';
    }

    public function order(){
        return $this->hasMany('App\Models\Order','payment_method_id');
    }

}
