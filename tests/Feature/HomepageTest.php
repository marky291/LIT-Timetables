<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Requests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
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
