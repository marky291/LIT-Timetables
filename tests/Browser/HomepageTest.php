<?php

namespace Tests\Browser;

use App\Models\Course;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomepageTest extends DuskTestCase
{
    public function test_can_see_homepage_hero_title()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertSee('Smarter approach to web timetables');
        });
    }

    public function test_can_click_search_in_navigation_bar()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertSee('Quick search for anything')->click('@search-nav')->assertSee('No recent searches');
        });
    }

    public function test_can_click_search_in_hero_landing()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertSee('Start Search')->click('@button-search')->assertSee('No recent searches');
        });
    }

    public function test_click_learn_more_opens_url()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertSee('Learn More')->click('@href-learnmore');
        });
    }
}
