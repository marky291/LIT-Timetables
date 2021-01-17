<?php

namespace Tests\Feature\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Search;
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
    public function one_recent_item_is_displayed_on_search()
    {
        $course = Course::factory()->create();

        $search = Search::factory()->create([
            'searchable_id' => $course->id,
            'searchable_type' => Course::class,
        ])->get();

        Livewire::test('search')
            ->set('recent', $search)
            ->assertSee($course->name);
    }

    /** @test */
    public function one_recent_item_is_displayed_and_deleted_on_search()
    {
        $course = Course::factory()->create();

        $search = Search::factory()->create([
            'searchable_id' => $course->id,
            'searchable_type' => Course::class,
        ])->get();

        Livewire::test('search')
            ->set('recent', $search)
            ->call('delete', $search->first()->id)
            ->assertDontSee($course->name);
    }

    /** @test */
    public function one_recent_item_can_be_favorited()
    {
        $course = Course::factory()->create();

        $search = Search::factory()->create([
            'favorite' => false,
            'searchable_id' => $course->id,
            'searchable_type' => Course::class,
        ])->get();

        Livewire::test('search')
            ->set('recent', $search)
            ->assertDontSee('favorites')
            ->call('favorite', $search->first()->id)
            ->assertSee('favorites')
            ->assertDontSee($course->name);
    }
}
