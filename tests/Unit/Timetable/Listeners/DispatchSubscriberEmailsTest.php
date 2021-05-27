<?php

namespace Tests\Unit\Timetable\Listeners;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\User;
use App\Timetable\Jobs\CompareSchedule;
use App\Timetable\Listeners\DispatchSubscriberEmails;
use App\Timetable\Mail\CourseTimetableChanged;
use App\Timetable\Mail\LecturerScheduleChanged;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;

class DispatchSubscriberEmailsTest extends TestCase
{

    use RefreshDatabase;

    public function test_email_sends_one_email_to_course_subscribers()
    {
        Mail::fake();

        Course::factory()
            ->has(User::factory()->count(1), 'subscribers')
            ->create();

        (new CompareSchedule(Course::find(1),
            collect(array($this->schedule(['module' => 'Before']))),
            collect(array($this->schedule(['module' => 'After'])))
        ))->handle();

        Mail::assertSent(CourseTimetableChanged::class, 1);
    }

    public function test_email_sends_one_email_to_lecturer_subscribers()
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
