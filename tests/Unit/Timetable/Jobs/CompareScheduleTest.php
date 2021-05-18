<?php

namespace Tests\Timetable\Jobs;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\User;
use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Jobs\CompareSchedule;
use App\Timetable\Mail\CourseTimetableChanged;
use App\Timetable\Mail\LecturerScheduleChanged;
use App\Timetable\Mail\TimetableChanges;
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

    public function test_email_sends_to_course_subscribers()
    {
        Mail::fake();

        Course::factory()
            ->has(User::factory()->count(2), 'subscribers')
            ->create();

        (new CompareSchedule(Course::find(1),
            collect(array($this->schedule(['module' => 'Before']))),
            collect(array($this->schedule(['module' => 'After'])))
        ))->handle();

        Mail::assertSent(CourseTimetableChanged::class, 2);
    }

    public function test_email_sends_to_lecturer_subscribers()
    {
        Mail::fake();

        $lecturer = Lecturer::factory()
            ->has(Schedule::factory())
            ->has(User::factory(), 'subscribers')
            ->create();

        (new CompareSchedule(Course::first(),
            collect(array($this->schedule(['room' => 'A', 'lecturer' => $lecturer->fullname]))),
            collect(array($this->schedule(['room' => 'B', 'lecturer' => $lecturer->fullname]))),
        ))->handle();

        Mail::assertSent(LecturerScheduleChanged::class, 1);
    }

//    public function test_email_does_not_spam()
//    {
//        Mail::fake();
//
//        $lecturer = Lecturer::factory()
//            ->has(Schedule::factory())
//            ->has(User::factory(), 'subscribers')
//            ->create();
//
//        $user = User::first();
//
//        Cache::shouldReceive('remember')
//            ->once()
//            ->with("Email::{$user->email}", 600);
//
//        (new CompareSchedule(Course::first(),
//            $this->fakeHtmlSchedule(['room' => 'A', 'lecturer' => $lecturer->fullname]),
//            $this->fakeHtmlSchedule(['room' => 'B', 'lecturer' => $lecturer->fullname]),
//        ))->handle();
//
//        (new CompareSchedule(Course::first(),
//            $this->fakeHtmlSchedule(['room' => 'A', 'lecturer' => $lecturer->fullname]),
//            $this->fakeHtmlSchedule(['room' => 'B', 'lecturer' => $lecturer->fullname]),
//        ))->handle();
//
//        Mail::assertQueued(TimetableChanged::class, 1);
//    }

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
