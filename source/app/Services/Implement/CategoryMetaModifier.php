<?php
namespace App\Services\Implement;

use App\Services\Interfaces\CategoryMetaServiceInterface;
use App\Services\Implement\BaseModifier;
use App\Services\Interfaces\ObjectModifierInterface;
use App\Models\CategoryMeta;
use App\Services\Formatter\CategoryMetaInput;

/**
 *
 */
class CategoryMetaModifier extends BaseModifier
{

  protected $model;
  public function __construct(){
    $this->model = CategoryMeta::class;
  }
}
