<?php
namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

/**
 *
 */
interface ObjectModifierInterface
{
  public function deleteDeleted(Collection $oldList, array $newList);
  public function updateUpdated(Collection $oldList, array $newList);
  public function addAdded(array $data);
}
