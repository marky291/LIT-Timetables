<?php

namespace Tests\Unit\Models;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Lecturer;
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
        $course = Course::factory()->has(Requests::factory()->count(3))->create();

        $this->assertNotNull(3, $course->requests);
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

    public function test_it_has_lecturers()
    {
        $course = Course::factory()
            ->has(Schedule::factory()->count(3)
            ->hasAttached(Lecturer::factory()->count(1)))
            ->create(['name' => 'Test Course Name']);

        $this->assertCount(3, $course->fresh()->lecturers);
    }

    public function test_course_has_a_name()
    {
        $course = Course::factory()->create(['name' => 'Business Studies with Sports Management - Year 4 Group B']);

        $this->assertEquals('Business Studies with Sports Management - Year 4 Group B', $course->name);
    }

    public function test_course_has_a_lookup()
    {
        $course = Course::factory()->create(['identifier' => 'm_sltSmgmt4B']);

        $this->assertEquals('m_sltSmgmt4B', $course->identifier);
    }

    public function test_course_has_a_year()
    {
        $course = Course::factory()->create(['year' => 4]);

        $this->assertEquals(4, $course->year);
    }

    public function test_course_has_a_group()
    {
        $course = Course::factory()->create(['group' => 'B']);

        $this->assertEquals('B', $course->group);
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
