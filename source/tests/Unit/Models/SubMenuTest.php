<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SubMenu;

class SubMenuTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $subMenu = factory(SubMenu::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $subMenu->status());
    }

    public function testStatusInactive()
    {
        $subMenu = factory(SubMenu::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Không hoạt động', $subMenu->status());
    }


    public function testStatusClassActive()
    {
        $subMenu = factory(SubMenu::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $subMenu->status_class());
    }

    public function testStatusClassInactive()
    {
        $subMenu = factory(SubMenu::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--danger', $subMenu->status_class());
    }

}
