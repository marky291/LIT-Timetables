<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function testHomepageStatus()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
