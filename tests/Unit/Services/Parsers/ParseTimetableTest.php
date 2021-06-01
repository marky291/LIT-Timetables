<?php

namespace Tests\Unit\Timetable\Parsers;

use App\Services\Parsers\ParseTimetableService;
use Goutte\Client;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class ParseTimetableTest extends TestCase
{
    private function fakeRequest(string $file)
    {
        return Mockery::mock(Client::class, static function (MockInterface $mock) use ($file) {
            $mock->shouldReceive('request')->once()->andReturn(
                new Crawler(File::get(base_path("/tests/{$file}.txt")))
            );
        });
    }

    public function test_it_can_count_all_schedules()
    {
        $service = new ParseTimetableService($this->fakeRequest('/Unit/Samples/html-snapshot')->request('GET', 'https://timetable.com'));

        $this->assertCount(14, $service->allSchedules()->get('schedules'));
    }

    public function test_it_has_starting_and_ending_time()
    {
        $service = new ParseTimetableService($this->fakeRequest('/Unit/Samples/html-snapshot')->request('GET', 'https://timetable.com'));

        $this->assertEquals('16:00', $service->allSchedules()->get('schedules')->first()['starting_time']);
        $this->assertEquals('17:00', $service->allSchedules()->get('schedules')->first()['ending_time']);
    }
}
