<?php

namespace Tests\Unit\Models;

use App\Models\Synchronization;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SynchronizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_retrieve_last_synchronized_date()
    {
        $date = Carbon::create(2021, 01, 01, 00, 00, 00);

        Synchronization::factory()->create([
            'created_at' => $date,
        ]);

        $this->assertInstanceOf(Carbon::class, Synchronization::lastRun());
        $this->assertEquals($date, Synchronization::lastRun());
    }

    public function test_can_retrieve_time_difference()
    {
        Carbon::setTestNow(Carbon::create(2021, 01, 01, 02, 00, 00));

        $lastRun = Carbon::create(2021, 01, 01, 00, 00, 00);

        Synchronization::factory()->create([
            'created_at' => $lastRun,
        ]);

        $this->assertEquals('2 hours ago', Synchronization::lastRun()->diffForHumans());
    }

    public function test_can_retrieve_day_difference()
    {
        Carbon::setTestNow(Carbon::create(2021, 01, 12, 00, 00, 00));

        $lastRun = Carbon::create(2021, 01, 01, 00, 00, 00);

        Synchronization::factory()->create([
            'created_at' => $lastRun,
        ]);

        $this->assertEquals(11, Synchronization::lastRun()->diff(now())->days);
    }
}
