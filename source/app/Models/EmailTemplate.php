<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class EmailTemplate extends Model
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
    protected $table = 'email_templates';

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
        if (count($this->email_templates) > 0) {
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
        return $this->active ? __('admin.email_templates.status.active') : __('admin.email_templates.status.inactive');
    }

    public function status_class()
    {
        return $this->active ? 'm-badge--success' : 'm-badge--metal';
    }

}
