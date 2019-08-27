<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Configuration extends Model
{
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configurations';

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
        'config_type',
        'config_key',
        'config_value',
    ];

    public function imageUrl()
    {
        if(!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.CONFIGURATION_IMAGE')). '/' . $this->config_value['image'])){
            return asset(config('constants.UPLOAD.CONFIGURATION_IMAGE') . '/' . $this->config_value['image']);
        }
        return url(config('constants.DEFAULT.CONFIGURATION_IMAGE'));
    }
}
