<?php

namespace Tests\Unit\Timetable\Collections;

use App\Models\Schedule;
use App\Timetable\Collections\ScheduleCollection;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_the_schedule_today_from_latest()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 1, 12, 20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 13, 00, 00)]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_schedule_previous_from_latest()
    {
        Carbon::setTestNow(Carbon::create('2020', 01, 8, 12, 20, 02));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01,01, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01,01, 13, 00, 00)]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->today());
    }

    public function test_it_can_get_the_upcoming_schedules_from_latest()
    {
        Carbon::setTestNow(Carbon::create(2020, 1, 8, 12, 00, 00));

        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 1, 8, 10, 00, 00), 'ending_date' => Carbon::create(2020, 1, 8, 11, 00, 00)]);
        Schedule::factory()->create(['starting_date' => Carbon::create(2020, 01, 8, 12, 00, 00), 'ending_date' => Carbon::create(2020, 01, 8, 13, 00, 00)]);

        $this->assertCount(1, Schedule::latestAcademicWeek()->get()->upcoming());
    }
}
