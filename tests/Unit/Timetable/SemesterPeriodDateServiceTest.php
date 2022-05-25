<?php

namespace Tests\Unit\Timetable;

use App\Services\SemesterPeriodDateService;
use Carbon\Carbon;
use Tests\TestCase;

class SemesterPeriodDateServiceTest extends TestCase
{
    public function test_it_can_get_first_semester_starting_date_in_current_year()
    {
        $semester = new SemesterPeriodDateService(Carbon::create(2020, 11, 25, 9, 21, 00));

        $expectedStart = Carbon::parse('30 August 2020');
        $expectedFinish = Carbon::parse('14 December 2020');

        $this->assertEquals($expectedStart, $semester->firstPeriod()->get('start'));
        $this->assertEquals($expectedFinish, $semester->firstPeriod()->get('finish'));
    }

    public function test_it_can_get_first_semester_starting_date_when_in_next_year()
    {
        $semester = new SemesterPeriodDateService(Carbon::create(2021, 03, 9, 2, 13, 21));

        $expectedStart = Carbon::parse('30 August 2020');
        $expectedFinish = Carbon::parse('14 December 2020');

        $this->assertEquals($expectedStart, $semester->firstPeriod()->get('start'));
        $this->assertEquals($expectedFinish, $semester->firstPeriod()->get('finish'));
    }

    public function test_it_can_get_second_semester_starting_date_in_current_year()
    {
        $semester = new SemesterPeriodDateService(Carbon::create(2020, 11, 25, 9, 21, 00));

        $expectedStart = Carbon::parse('11 January 2021');
        $expectedFinish = Carbon::parse('10 May 2021');

        $this->assertEquals($expectedStart, $semester->secondPeriod()->get('start'));
        $this->assertEquals($expectedFinish, $semester->secondPeriod()->get('finish'));
    }

    public function test_it_can_get_second_semester_starting_date_when_in_next_year()
    {
        $semester = new SemesterPeriodDateService(Carbon::create(2021, 03, 9, 2, 13, 21));

        $expectedStart = Carbon::parse('11 January 2021');
        $expectedFinish = Carbon::parse('10 May 2021');

        $this->assertEquals($expectedStart, $semester->secondPeriod()->get('start'));
        $this->assertEquals($expectedFinish, $semester->secondPeriod()->get('finish'));
    }

    public function test_it_can_get_weeks_since_semester_started()
    {
        $semester = new SemesterPeriodDateService(Carbon::create(2021, 03, 9, 2, 13, 21));

        $this->assertEquals(28, $semester->week());
    }

    public function test_it_can_get_current_semester()
    {
        $semesterOne = new SemesterPeriodDateService(Carbon::create(2020, 11, 9, 2, 13, 21));
        $semesterTwo = new SemesterPeriodDateService(Carbon::create(2021, 03, 9, 2, 13, 21));

        $this->assertEquals(1, $semesterOne->semester());
        $this->assertEquals(2, $semesterTwo->semester());
    }

    public function test_it_can_get_total_weeks_in_first_period()
    {
        $semester = new SemesterPeriodDateService(now());

        $this->assertEquals(17, $semester->weeksInFirstPeriod());
    }
}
