<?php

namespace Tests\Unit\Timetable\Converters;

use App\Timetable\Parsers\ParseFilters;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ConvertTimetableFiltersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ParseFilters
     */
    private $filter;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->filter = new ParseFilters(File::get(base_path('tests/Unit/Samples/java-snapshot.txt')));
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_returns_a_department_count_of_15(): void
    {
        $departments = $this->filter->departments();

        $this->assertCount(16, $departments);
    }

    public function test_it_returns_a_department_name(): void
    {
        $department = $this->filter->departments()->first()->name;

        $this->assertEquals('Limerick Institute of Technology', $department);
    }

    public function test_it_returns_a_department_code(): void
    {
        $code = $this->filter->departments()->first()->filter;

        $this->assertEquals('D100', $code);
    }

    public function test_it_returns_a_module_count_of_4196(): void
    {
        $zones = $this->filter->modules();

        $this->assertCount(4570, $zones);
    }

    public function test_it_returns_a_module_title(): void
    {
        $zone = $this->filter->modules()->first();

        $this->assertEquals('TEMP - Law of Torts 1', $zone->name);
    }

    public function test_it_returns_a_module_code(): void
    {
        $zone = $this->filter->modules()->first();

        $this->assertEquals('D242', $zone->filter);
    }

    public function test_it_returns_a_module_slug(): void
    {
        $zone = $this->filter->modules()->first();

        $this->assertEquals('TEMP', $zone->slug);
    }
}
