<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Requests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function testCourseViewPage()
    {
        $course = Course::factory()->has(Requests::factory()->count(1))->create();

        $response = $this->get("courses/{$course->identifier}");

        $response->assertStatus(200);
    }
}
