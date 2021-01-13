<?php

namespace Tests\Feature\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_search_menu_shows_no_recent_searches()
    {
        Livewire::test('search')->set('recent', new Collection())->assertSee('No recent searches');
    }

    /** @test */
    public function the_courses_are_shown_on_the_results()
    {
        $course = Course::factory()->create();

        Livewire::test('search')
            ->set('search', $course->name)
            ->assertsee('courses')
            ->assertDontSee('lecturers')
            ->assertSee($course->name);
    }

    /** @test */
    public function the_lecturers_are_shown_on_the_results()
    {
        $lecturer = Lecturer::factory()->create();

        Livewire::test('search')
            ->set('search', $lecturer->fullname)
            ->assertsee('lecturers')
            ->assertDontSee('courses')
            ->assertSee($lecturer->fullname);
    }

    /** @test */
    public function the_lecturers_and_courses_are_shown_on_the_results()
    {
        $course = Course::factory()->create(['name' => 'Fake Course']);
        $lecturer = Lecturer::factory()->create(['fullname' => 'Fake Lecturer']);

        Livewire::test('search')
            ->set('search', 'fake')
            ->assertsee('lecturers')
            ->assertSee('courses')
            ->assertSee($lecturer->fullname)
            ->assertSee($course->name);
    }

    /** @test */
    public function the_recent_course_is_shown_on_search()
    {
        $course = Course::factory()->create();

        Livewire::test('search')
            ->assertSee($course->name);
    }
}
