<?php

namespace Tests\Unit\Timetable\Jobs;

use App\Models\Course;
use App\Models\Department;
use App\Timetable\Converters\ConvertTimetableFilters;
use App\Timetable\Jobs\CreateDepartmentCourses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TimetableSourceFiltersTestOld extends TestCase
{
    use RefreshDatabase;

    private function ProcessTimetableSource()
    {
        (new CreateDepartmentCourses(new ConvertTimetableFilters(File::get(base_path('/tests/Samples/java-snapshot.txt')))))->handle();

        return $this;
    }

    public function test_it_process_sixteen_departments()
    {
        $this->ProcessTimetableSource();

        $this->assertEquals(16, Department::count());
    }

    public function test_it_process_one_thousand_sixteen_courses()
    {
        $this->ProcessTimetableSource();

        $this->assertEquals(507, Course::count());
    }

    public function test_it_does_not_duplicate_departments()
    {
        $this->ProcessTimetableSource()->ProcessTimetableSource();

        $this->assertEquals(16, Department::count());
    }

    public function test_it_does_not_duplicate_courses()
    {
        $this->ProcessTimetableSource()->ProcessTimetableSource();

        $this->assertEquals(507, Course::count());
    }
}
