<?php

namespace Tests\Unit\Models;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Requests;
use App\Models\Schedule;
use App\Models\Search;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_schedules()
    {
        $course = Course::factory()->has(Schedule::factory()->count(1))->create();

        $this->assertCount(1, $course->schedules);
    }

    public function test_it_has_requests()
    {
        $course = Course::factory()->has(Requests::factory()->count(1))->create();

        $this->assertNotNull(1, $course->requests);
    }

    public function test_it_has_request()
    {
        $course = Course::factory()->has(Requests::factory()->count(1))->create();

        $this->assertNotNull($course->request);
    }

    public function test_it_has_a_campus()
    {
        $course = Course::factory()->has(Campus::factory(['location' => 'Moylish', 'City' => 'Limerick']))->create();

        $this->assertNotNull($course->campus);
    }

    /** @test */
    public function it_has_a_search_relationship()
    {
        $course = Course::factory()->create();

        Search::factory()->create([
            'searchable_id' => $course->id,
            'searchable_type' => Course::class,
        ]);

        $this->assertEquals(1, $course->searches()->count());
    }
}
