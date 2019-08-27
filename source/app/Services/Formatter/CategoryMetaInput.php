<?php
namespace App\Services\Formatter;


class CategoryMetaInput{

  public function setCategoryId(int $category_id, array $data){
    foreach($data as &$row){
      $row['category_id'] = $category_id;
    }
    return $data;
  }

}
