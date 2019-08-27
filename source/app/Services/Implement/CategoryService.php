<?php
namespace App\Services\Implement;

use App\Models\Category;
use App\Services\Implement\CategoryMetaModifier;
use App\Services\Formatter\CategoryMetaInput;

class CategoryService
{
    protected $categoryMetaModifier;
    protected $catMetaFormatter;
    public function __construct(CategoryMetaModifier $categoryMetaModifier, CategoryMetaInput $catMetaFormatter){
        $this->categoryMetaModifier = $categoryMetaModifier;
        $this->catMetaFormatter = $catMetaFormatter;
    }

    public function addMeta(Category $category, array $data){
      $data = $this->catMetaFormatter->setCategoryId($category->id, $data);
      $this->categoryMetaModifier->addAdded($data);
    }

    public function editMeta(Category $category, array $data){

      $category->load('category_metas');

      $this->categoryMetaModifier->deleteDeleted($category->category_metas,$data);

      $newMeta = collect($data)->where('id',0)->toArray();
      $this->addMeta($category, $newMeta);

      $this->categoryMetaModifier->updateUpdated($category->category_metas,$data);
    }
}
