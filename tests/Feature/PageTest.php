<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Requests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function testHomepageStatus()
    {
        $this->get('/')->assertStatus(200);
    }

    public function testCourseViewPage()
    {
        $course = Course::factory()->has(Requests::factory()->count(1))->create();

        $this->get("courses/{$course->identifier}")->assertStatus(200);
    }
}
