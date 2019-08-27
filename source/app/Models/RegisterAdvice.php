<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterAdvice extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'register_advices';

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
    protected $fillable = ['name', 'phone','status','service_id'];

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
