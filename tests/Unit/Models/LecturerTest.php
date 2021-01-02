<?php

namespace Tests\Unit\Models;

use App\Models\Lecturer;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LecturerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_uuid_on_creation()
    {
        $lecturer = Lecturer::factory()->create(['uuid' => '']);

        $this->assertNotEmpty($lecturer->uuid);
    }

    public function test_lecturers_have_schedules()
    {
        $lecturer = Lecturer::factory()->create(['fullname' => 'Unit Test']);

        $schedules = Schedule::factory()->count(3)->create(['lecturer_id' => $lecturer->id]);

        $this->assertCount(3, $lecturer->schedules);
    }

}
