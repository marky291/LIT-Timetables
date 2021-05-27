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

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00),
            'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)
        ]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_distinct_schedule_today()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 1, 12, 20, 02));

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00),
            'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)
        ]);

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00),
            'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)
        ]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->distinct());
    }

    public function test_it_can_get_the_schedule_previous_from_latest()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 8, 12, 20, 02));

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 01, 01, 12, 00, 00),
            'ending_date' => Carbon::create(2020, 01, 01, 13, 00, 00)
        ]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_upcoming_schedules_from_latest()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 11, 00, 00));

        $schedule1 = Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00),
            'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)
        ]);

        $schedule2 = Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 12, 00, 00),
            'ending_date' => Carbon::create(2020, 1, 8, 13, 00, 00)
        ]);

        $this->assertEquals($schedule2->id, Schedule::latestAcademicWeek()->get()->upcoming()->first()->id);
    }

    public function test_it_can_get_the_upcoming_schedules_collection()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 14, 00, 00));

        $schedule1 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)]);
        $schedule2 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 12, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 13, 00, 00)]);
        $schedule3 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 14, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 15, 00, 00)]);
        $schedule4 = Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 16, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 18, 00, 00)]);

        $this->assertCount(2, Schedule::all()->upcoming());
    }

    public function test_upcoming_schedules_collection_contains_current_schedule()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 10, 36, 00));

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00),
            'ending_date'   => Carbon::create(2020, 1, 8, 11, 00, 00)
        ]);

        $this->assertCount(1, Schedule::all()->upcoming());
    }

    public function test_upcoming_retrieves_next_class()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 14, 48, 00));

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 11, 00, 00),
            'ending_date'   => Carbon::create(2020, 1, 8, 12, 00, 00)
        ]);

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 14, 00, 00),
            'ending_date'   => Carbon::create(2020, 1, 8, 16, 00, 00)
        ]);

       $this->assertCount(1, Schedule::all()->upcoming()->distinct());
    }

    public function test_upcoming_today_retrieves_the_next_class_on_this_day()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 1, 14, 48, 00));

        Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 11, 00, 00),
            'ending_date'   => Carbon::create(2020, 1, 8, 12, 00, 00)
        ]);

        $expected = Schedule::factory()->create([
            'starting_date' => Carbon::create(2020, 1, 8, 14, 00, 00),
            'ending_date'   => Carbon::create(2020, 1, 8, 16, 00, 00)
        ]);

        $this->assertCount(1, Schedule::all()->upcoming()->today());
        $this->assertEquals($expected->fresh(), Schedule::all()->upcoming()->today()->first());
    }

    public function test_it_can_sort_and_order_a_week()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 11, 00, 00));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 11, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 12, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 10, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 10, 11, 00, 00)]);

        $this->assertCount(3, Schedule::all()->sortWeek());  // make sure it breaks into days (three days)
    }

    public function test_it_can_sort_and_order_a_week_uniquely()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 11, 00, 00));

        // it is possible a class is made up of multiple groupings, causing
        // a duplicate timetable schedule for a lecturer.
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 9, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 9, 10, 00, 00)]);

        $this->assertCount(1, Schedule::all()->sortWeek()->first());
    }
}
