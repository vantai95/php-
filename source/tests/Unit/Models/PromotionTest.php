<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Promotion;

class PromotionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $promotion = factory(Promotion::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $promotion->status());
    }

    public function testStatusInactive()
    {
        $promotion = factory(Promotion::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $promotion->status());
    }


    public function testStatusClassActive()
    {
        $promotion = factory(Promotion::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $promotion->status_class());
    }

    public function testStatusClassInactive()
    {
        $promotion = factory(Promotion::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $promotion->status_class());
    }
}
