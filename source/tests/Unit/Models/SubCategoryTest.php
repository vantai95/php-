<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SubCategory;

class SubCategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $subCategory = factory(SubCategory::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $subCategory->status());
    }

    public function testStatusInactive()
    {
        $subCategory = factory(SubCategory::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $subCategory->status());
    }


    public function testStatusClassActive()
    {
        $subCategory = factory(SubCategory::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $subCategory->status_class());
    }

    public function testStatusClassInactive()
    {
        $subCategory = factory(SubCategory::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $subCategory->status_class());
    }
}
