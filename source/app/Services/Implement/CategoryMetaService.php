<?php
namespace App\Services\Implement;

use App\Services\Interfaces\CategoryMetaServiceInterface;
use App\Services\Interfaces\ObjectModifierInterface;
use App\Models\CategoryMeta;
use App\Services\Formatter\CategoryMetaInput;

/**
 *
 */
class CategoryMetaService implements CategoryMetaServiceInterface, ObjectModifierInterface
{
  protected $inputFormatter;
  public function __construct(CategoryMetaInput $inputFormatter){
    $this->inputFormatter = $inputFormatter;
  }

  public function store($category_id, $data){
    $data = $this->inputFormatter->setCategoryId($category_id, $data);
    CategoryMeta::insert($data);
  }

  public function update($id, $data){
  }

  public function delete($id){

  }

  public function getDeleted($oldList, $newList){
    $newList = collect($newList);
    foreach($oldList as $item){
      $existInNewList = $newList->where('id',$item->id)->count() > 0;
      if( $existInNewList ){
        $item->delete();
      }
    }
  }

  public function getUpdated($oldList, $newList){

  }

  public function getAdded($newList){

  }

}
