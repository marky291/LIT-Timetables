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
        Livewire::test('search')
            ->set('search', '')
            ->assertSee('No recent searches');
    }

    /** @test */
    public function the_courses_are_shown_on_the_results()
    {
        $course = Course::factory()->create(['name' => 'Course Name']);

        Livewire::test('search')
            ->set('search', 'name')
            ->assertSeeText('courses')
            ->assertDontSee('lecturers')
            ->assertSeeText('Course Name');
    }

    /** @test */
    public function the_lecturers_are_shown_on_the_results()
    {
        $course = Lecturer::factory()->create(['fullname' => 'Lecturer Name']);

        Livewire::test('search')
            ->set('search', 'name')
            ->assertSeeText('lecturers')
            ->assertDontSee('courses')
            ->assertSeeText('Lecturer Name');
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
        Course::factory()->create(['name' => 'Course Name']);

        Livewire::test('search')
            ->call('click', Course::class, 1, 'test.com');

        Livewire::test('search')
            ->assertSeeText('Course Name');
    }

    /** @test */
    public function one_recent_item_is_displayed_and_deleted_on_search()
    {
        Course::factory()->create(['name' => 'Course Name']);

        Livewire::test('search')
            ->call('click', Course::class, 1, 'test.com');

        Livewire::test('search')
            ->assertSeeText('Course Name');

        Livewire::test('search')
            ->call('delete', 1);

        Livewire::test('search')
            ->assertDontSeeText('Course Name');
    }

    /** @test */
    public function one_recent_item_can_be_favorited()
    {
        Course::factory()->create(['name' => 'Course Name']);

        Livewire::test('search')
            ->call('favorite', Course::class, 1);

        Livewire::test('search')
            ->assertSeeText('Favorites')
            ->assertSeeText('Course Name');
    }

    /** @test */
    public function errors_are_displayed_on_the_search()
    {
        $error_msg = 'Error Test';

        Livewire::test('search')
            ->set('error', $error_msg)
            ->assertSee($error_msg);
    }

    /** @test */
    public function searched_results_are_cleared_on_text_clear()
    {
        $lecturer = Lecturer::factory()->create(['fullname' => 'Lecturer Name']);
        $course = Course::factory()->create(['name' => 'Course Name']);

        Livewire::test('search')
            ->set('search', 'name')
            ->assertSee('Lecturer Name')
            ->assertSee('Course Name')
            ->set('search', '')
            ->assertSee('No recent searches')
            ->set('search', 'name')
            ->assertSee('Lecturer Name')
            ->assertSee('Course Name')
            ->set('search', '')
            ->assertSee('No recent searches');
    }

    /** @test */
    public function only_one_favorite_is_shown_when_text_is_cleared()
    {
        Course::factory()->create(['name' => 'Course Name 1']);
        Course::factory()->create(['name' => 'Course Name 2']);
        Course::factory()->create(['name' => 'Course Name 3']);
        Lecturer::factory()->create(['fullname' => 'Lecturer Name 1']);

        Livewire::test('search')
            ->call('favorite', Course::class, 2);

        Livewire::test('search')
            ->assertSeeText('Favorites')
            ->assertDontSeeText('Course Name 1')
            ->assertDontSeeText('Course Name 3')
            ->assertSeeText('Course Name 2');

        Livewire::test('search')
            ->set('search', 'n')
            ->assertSeeText('Course Name 1')
            ->assertSeeText('Course Name 3')
            ->assertSeeText('Course Name 2')
            ->assertSeeText('Lecturer Name 1')
            ->set('search', '')
            ->assertDontSeeText('Course Name 1')
            ->assertDontSeeText('Course Name 3')
            ->assertDontSeeText('Lecturer Name 1')
            ->assertSeeText('Course Name 2');
    }

    /** @test */
    public function searched_results_no_results_found()
    {
        Course::factory()->create(['name' => 'Test Course']);

        Livewire::test('search')
            ->set('search', 'test')
            ->assertSee('Test Course')
            ->set('search', 'x')
            ->assertSee('No search results found');
    }

    /** @test */
    public function search_clears_recent_search()
    {
        Course::factory()->create(['name' => 'Social Care Work - Year 1 Group A']);

        Lecturer::factory()->create(['fullname' => 'Eamon Nyhan']);

        Livewire::test('search')
            ->set('search', 'e')
            ->assertSeeText('Social Care Work - Year 1 Group A')
            ->assertSeeText('Eamon Nyhan')
            ->set('search', '')
            ->assertDontSeeText('Social Care Work - Year 1 Group A')
            ->assertDontSeeText('Eamon Nyhan')
            ->set('search', 'e')
            ->assertSeeText('Social Care Work - Year 1 Group A')
            ->assertSeeText('Eamon Nyhan');
    }
}
