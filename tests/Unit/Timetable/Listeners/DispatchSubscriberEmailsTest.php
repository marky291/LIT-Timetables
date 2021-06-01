<?php

namespace Tests\Unit\Timetable\Listeners;

use App\Actions\Course\CompareSchedules;
use App\Mail\CourseTimetableChangedMail;
use App\Mail\LecturerScheduleChangedMail;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\User;
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

        CompareSchedules::run(
            Course::find(1),
            collect(array($this->schedule(['module' => 'Before']))),
            collect(array($this->schedule(['module' => 'After'])))
        );

        Mail::assertSent(CourseTimetableChangedMail::class, 1);
    }

    public function test_email_sends_one_email_to_lecturer_subscribers()
    {
        Mail::fake();

        $lecturer = Lecturer::factory()
            ->has(Schedule::factory())
            ->has(User::factory(), 'subscribers')
            ->create();

        CompareSchedules::run(
            Course::first(),
            collect(array($this->schedule(['room' => 'A', 'lecturer' => $lecturer->fullname]))),
            collect(array($this->schedule(['room' => 'B', 'lecturer' => $lecturer->fullname]))),
        );

        Mail::assertSent(LecturerScheduleChangedMail::class, 1);
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
