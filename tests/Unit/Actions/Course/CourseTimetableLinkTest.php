<?php

namespace Tests\Unit\Actions\Course;

use App\Actions\Course\CourseTimetableLink as CourseCourseTimetableLink;
use App\Models\Course;
use CourseTimetableLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTimetableLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_course_link()
    {
        $course = Course::factory()->create(['identifier' => 'CSC108H1']);

        $timetableLink = new CourseCourseTimetableLink;

        $expectedResult = sprintf(config('services.lit.relay.timetable.route'), 'CSC108H1');

        $this->assertEquals($expectedResult, $timetableLink->handle($course));
    }

    public function test_it_returns_a_course_link_with_a_specified_week()
    {
        $course = Course::factory()->create(['identifier' => 'CSC108H1']);

        $timetableLink = new CourseCourseTimetableLink;

        $expectedResult = "http://timetable.lit.ie:8080/reporting/individual;student+set;id;CSC108H1?t=student+set+individual&template=student+set+individual&weeks=24";

        $this->assertEquals($expectedResult, $timetableLink->handle($course, 24));
    }
}
