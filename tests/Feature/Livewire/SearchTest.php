<?php

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function the_search_menu_shows_no_recent_searches()
    {
        Livewire::test('search')->assertSee('No recent searches');
    }
}
