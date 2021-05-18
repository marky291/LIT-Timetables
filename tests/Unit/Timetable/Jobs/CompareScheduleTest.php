<?php

namespace Tests\Timetable\Jobs;

use App\Exceptions\ScheduleComparisonIncorrectSize;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\User;
use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Jobs\CompareSchedule;
use App\Timetable\Mail\CourseTimetableChanged;
use App\Timetable\Mail\LecturerScheduleChanged;
use Cache;
use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Mail;
use Tests\TestCase;

class CompareScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_no_collection_data()
    {
        Event::fake();

        (new CompareSchedule(Course::factory()->create(),
            collect(array()),
            collect(array()),
        ))->handle();

        Event::assertNotDispatched(TimetableScheduleChanged::class);
    }

    public function test_inconsistant_array_length_handler()
    {
        $this->expectException(ScheduleComparisonIncorrectSize::class);

        (new CompareSchedule(Course::factory()->create(),
            collect(array($this->schedule())),
            collect(array($this->schedule(['extra' => 'length']))),
        ))->handle();
    }

    public function test_it_can_detect_no_timetable_change()
    {
        Event::fake();
        Course::factory()->create();

        (new CompareSchedule(Course::find(1),
            collect(array($this->schedule())),
            collect(array($this->schedule())),
        ))->handle();

        Event::assertNotDispatched(TimetableScheduleChanged::class);
    }

    public function test_it_can_detect_changes()
    {
        Event::fake();
        Course::factory()->create();

        (new CompareSchedule(Course::find(1),
            collect(array($this->schedule(['module' => 'Before']))),
            collect(array($this->schedule(['module' => 'After'])))
        ))->handle();

        Event::assertDispatched(TimetableScheduleChanged::class);
    }

    private function schedule(array $attributes = [])
    {
        return array_merge([
            "module" => "Software Development",
            "room" => "4A02",
            "lecturer" => "Judith Ryan",
            "type" => "Online Tutorial",
            "day_of_week" => "Fri",
            "starting_time" => "16:00",
            "ending_time" => "17:00",
        ], $attributes);
    }
}
