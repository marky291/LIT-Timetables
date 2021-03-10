<?php

namespace Tests\Unit\Timetable\Collections;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_the_schedule_today_from_latest()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 1, 12, 20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_schedule_previous_from_latest()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 8, 12, 20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_upcoming_schedules_from_latest()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 11, 00, 00));

        $schedule1 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)]);
        $schedule2 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01, 8, 13, 00, 00)]);

        $this->assertEquals($schedule2->id, Schedule::latestAcademicWeek()->get()->upcoming()->first()->id);
    }

    public function test_it_can_sort_and_order_a_week()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 11, 00, 00));

        $schedule1 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)]);
        $schedule2 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 11, 00, 00)]);
        $schedule3 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 11, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 12, 00, 00)]);
        $schedule4 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 10, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 10, 11, 00, 00)]);

        $this->assertCount(3, Schedule::all()->sortWeek());  // make sure it breaks into days (three days)
    }
}
