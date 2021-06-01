<?php

namespace Tests\Unit\Timetable\Jobs;

use App\Models\Course;
use App\Events\ScheduleChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Actions\Course\CompareSchedules;

class CompareScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_no_collection_data()
    {
        Event::fake();

        CompareSchedules::run(
            Course::factory()->create(),
            collect(array()),
            collect(array()),
        );

        Event::assertNotDispatched(ScheduleChanged::class);
    }

    public function test_it_can_detect_no_new_timetable()
    {
        Event::fake();

        CompareSchedules::run(
            Course::factory()->create(),
            collect(array($this->schedule())),
            collect(array()),
        );

        Event::assertDispatched(ScheduleChanged::class);
    }

    public function test_it_can_detect_no_timetable_change()
    {
        Event::fake();
        Course::factory()->create();

        CompareSchedules::run(
            Course::find(1),
            collect(array($this->schedule())),
            collect(array($this->schedule())),
        );

        Event::assertNotDispatched(ScheduleChanged::class);
    }

    public function test_it_can_detect_changes()
    {
        Event::fake();
        Course::factory()->create();

        CompareSchedules::run(
            Course::find(1),
            collect(array($this->schedule(['module' => 'Before']))),
            collect(array($this->schedule(['module' => 'After'])))
        );

        Event::assertDispatched(ScheduleChanged::class);
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
