<?php

namespace Tests\Unit\Models;

use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_determination_online_lecturers()
    {
        $onlineLecturer = Type::factory()->create(['abbreviation' => 'Online Lecture']);
        $onlinePractical = Type::factory()->create(['abbreviation' => 'Online Practical']);
        $onlineLabLecturer = Type::factory()->create(['abbreviation' => 'Online Lab Lecturer']);
        $practical = Type::factory()->create(['abbreviation' => 'Practical']);

        $this->assertTrue($onlineLecturer->isOnline());
        $this->assertTrue($onlinePractical->isOnline());
        $this->assertTrue($onlineLabLecturer->isOnline());
        $this->assertfalse($practical->isOnline());
    }
}
