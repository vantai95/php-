<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;

class Service extends Model
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
    protected $table = 'services';

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
    protected $fillable = ['active','name_en', 'name_vi', 'slug','short_description_en','short_description_vi', 'description_en', 'description_vi', 'image_before', 'image_after', 'video', 'category_id', 'faqs', 'services_feedbacks', 'image', 'price', 'promotions'];

    public function status()
    {
        if($this->active) {
            return __('admin.services.statuses.active');
        }
        return __('admin.services.statuses.inactive');
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

    public function imageUrl()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image)) {
            return asset(config('constants.UPLOAD.IMAGE_LIST') . '/' . $this->image);
        }
        return asset(config('constants.DEFAULT.IMAGE_LIST'));
    }

    public function faqList(){
        $data =$this->faqs;
        if($data){
            return $data;
        }
        return '';
    }

    public function register_advices(){
        return $this->hasMany('App\Models\RegisterAdvice', 'service_id');
    }
}
