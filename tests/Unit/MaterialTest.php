<?php

namespace Tests\Unit;

use App\Models\Material;
use Tests\TestCase;

class MaterialTest extends TestCase
{
    public function test_thumbnail_can_be_stored_and_read_as_an_array_of_urls()
    {
        $material = new Material();
        $material->setAttribute('thumbnail', ['thumb-1.jpg', 'thumb-2.jpg']);

        $this->assertSame('["thumb-1.jpg","thumb-2.jpg"]', $material->getAttributes()['thumbnail']);
        $this->assertSame(['thumb-1.jpg', 'thumb-2.jpg'], $material->getAttribute('thumbnail'));
    }

    public function test_image_url_is_kept_as_a_single_download_link()
    {
        $material = new Material();
        $material->setAttribute('image_url', 'https://example.com/files/demo.zip');

        $this->assertSame('https://example.com/files/demo.zip', $material->getAttributes()['image_url']);
        $this->assertSame('https://example.com/files/demo.zip', $material->getAttribute('image_url'));
    }
}
