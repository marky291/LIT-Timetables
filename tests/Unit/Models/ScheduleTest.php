<?php

namespace Tests\Unit\Models;

use App\Models\Schedule;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_an_academic_schedule()
    {
        $schedule = Schedule::factory()->create();

        $this->assertNotNull($schedule->academic_week);
    }

    public function test_it_can_get_distinct_schedules_only()
    {
        Schedule::factory()->count(2)->create(['starting_date' => now()]);

        $this->assertCount(1, Schedule::all()->distinct());
    }

    public function test_it_can_get_the_current_schedule()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 01, 12,20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 10, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 13, 00, 00)]);

        $this->assertEquals("2020-01-01 12:00:00", Schedule::current()->first()->starting_date);
    }

    public function test_it_can_get_the_current_days_schedule()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 01, 12,20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 10, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 13, 00, 00)]);

        $this->assertCount(2, Schedule::today()->get());
    }

    public function test_it_can_get_the_schedule_from_last_week()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 8, 12,20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 13, 00, 00)]);

        $this->assertCount(1, Schedule::previousWeek()->get());
    }
}
