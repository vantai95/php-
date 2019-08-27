<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Menu;

class MenuTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $menu = factory(Menu::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $menu->status());
    }

    public function testStatusInactive()
    {
        $menu = factory(Menu::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $menu->status());
    }


    public function testStatusClassActive()
    {
        $menu = factory(Menu::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $menu->status_class());
    }

    public function testStatusClassInactive()
    {
        $menu = factory(Menu::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $menu->status_class());
    }
}
