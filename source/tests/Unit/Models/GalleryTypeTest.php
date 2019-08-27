<?php

namespace Tests\Unit\Models;

use App\Models\Gallery;
use Tests\TestCase;
use App\Models\GalleryType;

class GalleryTypeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusActive()
    {
        $galleryType = factory(GalleryType::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('Hoạt động', $galleryType->status());
    }

    public function testStatusInactive()
    {
        $galleryType = factory(GalleryType::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('Ngưng hoạt động', $galleryType->status());
    }


    public function testStatusClassActive()
    {
        $galleryType = factory(GalleryType::class)->create([
            'active' => true,
        ]);
        $this->assertEquals('m-badge--success', $galleryType->status_class());
    }

    public function testStatusClassInactive()
    {
        $galleryType = factory(GalleryType::class)->create([
            'active' => false,
        ]);
        $this->assertEquals('m-badge--metal', $galleryType->status_class());
    }

    public function testCanDeleteTrue(){
        $galleryType = factory(GalleryType::class)->create([
            'active' => false,
        ]);
        $this->assertTrue($galleryType->canDelete());
    }

    public function testCanDeleteHaveGalleriesWithoutCode(){
        $gallerie = factory(Gallery::class)->create();
        $galleryType = factory(GalleryType::class)->create([
            'active' => false,
        ]);
        $this->assertFalse($galleryType->canDelete());
    }

    public function testCanDeleteHaveCodeWithoutGalleries(){
        $galleryType = factory(GalleryType::class)->create([
            'active' => false,
            'code' => 'some-code',
        ]);
        $this->assertFalse($galleryType->canDelete());
    }
}
