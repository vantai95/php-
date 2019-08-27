<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'menus';

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
    protected $fillable = ['active', 'name_en', 'name_vi', 'name_ja', 'url', 'sequence'];

    public function subMenus()
    {
        return $this->hasMany('App\Models\SubMenu');
    }

    public function status()
    {
        if($this->active) {
            return __('admin.menus.statuses.active');
        }
        return __('admin.menus.statuses.inactive');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }
}
