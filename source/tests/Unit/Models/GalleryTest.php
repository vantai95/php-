<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Gallery;

class GalleryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $gallery = factory(Gallery::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $gallery->status());
    }

    public function testStatusInactive()
    {
        $gallery = factory(Gallery::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Ngưng hoạt động', $gallery->status());
    }


    public function testStatusClassActive()
    {
        $gallery = factory(Gallery::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $gallery->status_class());
    }

    public function testStatusClassInactive()
    {
        $gallery = factory(Gallery::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--metal', $gallery->status_class());
    }

}
