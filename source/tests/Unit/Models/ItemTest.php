<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Item;

class ItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $item = factory(Item::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Active', $item->status());
    }

    public function testStatusInactive()
    {
        $item = factory(Item::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Inactive', $item->status());
    }

    public function testisSetItemTrue()
    {
        $item = factory(Item::class)->create([
            'item_type' => 'Set Menu',
        ]);
        $this->assertEquals('Set Menu', $item->isSetItem());
    }

    public function testisSetItemFalse()
    {
        $item = factory(Item::class)->create([
            'item_type' => 'Set Menu',
        ]);
        $this->assertNotEqual('Set Menu', $item->isSetItem());
    }
}
