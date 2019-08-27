<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
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
    protected $table = 'sub_menus';

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
    protected $fillable = ['active', 'name_en', 'name_vi', 'name_ja', 'url', 'sequence', 'menu_id'];

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }

    public function status()
    {
        if($this->active) {
            return __('admin.sub_menus.statuses.active');
        }
        return __('admin.sub_menus.statuses.inactive');
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }
}
