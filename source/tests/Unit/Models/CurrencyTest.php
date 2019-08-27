<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Currency;

class CurrencyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $currency = factory(Currency::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $currency->status());
    }

    public function testStatusInactive()
    {
        $currency = factory(Currency::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $currency->status());
    }


    public function testStatusClassActive()
    {
        $currency = factory(Currency::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $currency->status_class());
    }

    public function testStatusClassInactive()
    {
        $currency = factory(Currency::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $currency->status_class());
    }
}
