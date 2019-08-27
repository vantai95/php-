<?php

namespace App\Models;

use App\Services\CommonService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

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
        'image',
    ];

    public function getFileSize()
    {
        if (!empty($this->image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image)) {
            return CommonService::formatFileSize(File::size(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->image));
        }
        return '0';
    }

    public static function getAllImg(){
      $azureUrl = config('filesystems.disks.azure.url');
      $images = Image::select('id',\DB::raw("CONCAT('{$azureUrl}',image) as image"))->get();
      return $images;
    }

    public function getThumbFileSize()
    {
        if (!empty($this->thumb_image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->thumb_image)) {
            return CommonService::formatFileSize(File::size(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $this->thumb_image));
        }
        return '0';
    }

}
