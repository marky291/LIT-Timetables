<?php

namespace Tests\Unit\Timetable\Jobs;

use App\Models\Course;
use App\Timetable\Converters\ConvertTimetableFilters;
use App\Timetable\Jobs\CreateDepartmentCourses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CreateDepartmentCoursesTest extends TestCase
{
    use RefreshDatabase;

    private $converter;
    private $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = $this->dispatchDepartmentCourseCreation();

        $this->course = Course::first();
    }

    public function test_course_has_a_name()
    {
        $this->assertEquals('Business Studies with Sports Management - Year 4 Group B', $this->course->name);
    }

    public function test_course_has_a_lookup()
    {
        $this->assertEquals('m_sltSmgmt4B', $this->course->identifier);
    }

    public function test_course_has_a_year()
    {
        $this->assertEquals(4, $this->course->year);
    }

    public function test_course_has_a_group()
    {
        $this->assertEquals('B', $this->course->group);
    }

    public function test_course_has_a_campus()
    {
        $this->assertNotNull($this->course->campus);
    }

    public function test_command_does_not_duplicate_courses_when_run()
    {
        $this->assertCount(503, Course::all());

        $this->dispatchDepartmentCourseCreation();

        $this->assertCount(503, Course::all());
    }

    private function dispatchDepartmentCourseCreation()
    {
        CreateDepartmentCourses::dispatchNow(
            new ConvertTimetableFilters(
                File::get(base_path('/tests/Unit/Samples/java-snapshot.txt'))
            )
        );
    }
}
