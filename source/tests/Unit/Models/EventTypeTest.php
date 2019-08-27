<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\EventType;

class EventTypeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $eventType = factory(EventType::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $eventType->status());
    }

    public function testStatusInactive()
    {
        $eventType = factory(EventType::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $eventType->status());
    }


    public function testStatusClassActive()
    {
        $eventType = factory(EventType::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $eventType->status_class());
    }

    public function testStatusClassInactive()
    {
        $eventType = factory(EventType::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $eventType->status_class());
    }
}
