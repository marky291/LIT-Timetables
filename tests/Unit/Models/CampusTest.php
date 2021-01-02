<?php

namespace Tests\Unit\Models;

use App\Models\Campus;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampusTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_location()
    {
        $campus = Campus::factory()->create(['location' => 'Moylish']);

        $this->assertEquals('Moylish', $campus->location);
    }

    public function test_it_has_courses()
    {
        $campus = Campus::factory()->has(Course::factory())->create();

        $this->assertCount(1, $campus->courses);
    }

    public function test_it_has_a_city()
    {
        $campus = Campus::factory()->create(['location' => 'Moylish']);

        $this->assertEquals('limerick', $campus->city);
    }
}
