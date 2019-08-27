<?php

namespace Tests\Unit\Models;

use App\Models\SubCategory;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $category = factory(Category::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $category->status());
    }

    public function testStatusInactive()
    {
        $category = factory(Category::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $category->status());
    }


    public function testStatusClassActive()
    {
        $category = factory(Category::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $category->status_class());
    }

    public function testStatusClassInactive()
    {
        $category = factory(Category::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $category->status_class());
    }

    public function testCanDeleteTrue(){
        $category = factory(Category::class)->create([
            'active' => false,
        ]);
        $this->assertTrue($category->canDelete());
    }

    public function testCanDeleteFalse(){
        $subCategory = factory(SubCategory::class)->create();
        $category = factory(Category::class)->create([
            'active' => false,
        ]);
        $this->assertFalse($category->canDelete());
    }

}
