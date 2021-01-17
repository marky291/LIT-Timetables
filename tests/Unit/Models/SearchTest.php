<?php

namespace Tests\Unit\Models;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Search;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_made_a_favorite_search()
    {
        $search = Search::factory()
            ->for(Course::factory(), 'searchable')
            ->create(['favorite' => true]);

        $this->assertTrue($search->favorite);
    }

    /** @test */
    public function it_has_lecturer_relationship()
    {
        $search = Search::factory()
            ->for(Lecturer::factory(), 'searchable')
            ->create();

        $this->assertInstanceOf(Lecturer::class, $search->searchable);
    }

    /** @test */
    public function it_has_course_relationship()
    {
        $search = Search::factory()
            ->for(Course::factory(), 'searchable')
            ->create();

        $this->assertInstanceOf(Course::class, $search->searchable);
    }
}
