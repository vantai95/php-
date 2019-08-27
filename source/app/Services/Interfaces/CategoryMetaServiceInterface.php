<?php
namespace App\Services\Interfaces;

/**
 *
 */
interface CategoryMetaServiceInterface
{
  public function store($category_id, $data);
  public function update($id, $data);
  public function delete($id);
}
