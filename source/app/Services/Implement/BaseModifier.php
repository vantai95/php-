<?php
namespace App\Services\Implement;

use App\Services\Interfaces\CategoryMetaServiceInterface;
use App\Services\Interfaces\ObjectModifierInterface;
use App\Models\CategoryMeta;
use App\Services\Formatter\CategoryMetaInput;
use Illuminate\Support\Collection;

/**
 *
 */
class BaseModifier implements ObjectModifierInterface
{

  public function deleteDeleted(Collection $oldList, array $newList){
    $newList = collect($newList);
    foreach($oldList as $item){
      $existInNewList = $newList->where('id',$item->id)->first() != null;
      if( !$existInNewList ){
        $item->delete();
      }
    }
  }

  public function updateUpdated(Collection $oldList, array $newList){
    $newList = collect($newList);
    foreach($oldList as $item){
      $newItem = $newList->where('id',$item->id)->first();
      $existInNewList = $newItem != null;
      if( $existInNewList ){
        $item->update($newItem);
      }
    }
  }

  public function addAdded(array $data){
    return $this->model::insert($data);
  }

}
