<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Event;

class EventTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $event = factory(Event::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $event->status());
    }

    public function testStatusInactive()
    {
        $event = factory(Event::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $event->status());
    }


    public function testStatusClassActive()
    {
        $event = factory(Event::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $event->status_class());
    }

    public function testStatusClassInactive()
    {
        $event = factory(Event::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $event->status_class());
    }
}
