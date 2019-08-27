<?php
namespace App\Services;

use Storage;

class ImageService
{
    public static function imageUrl($img)
    {
      if(Storage::disk('azure')->exists($img)){
        return config('filesystems.disks.azure.url').$img;
      }else{
        return url(config('constants.DEFAULT.IMAGE_LIST'));
      }

    }
}
