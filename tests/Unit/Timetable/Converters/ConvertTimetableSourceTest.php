<?php

namespace Tests\Unit\Timetable\Converters;

use App\Timetable\Converters\ConvertTimetableSource;
use Mockery;
use Goutte\Client;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class ConvertTimetableSourceTest extends TestCase
{
    private function getMockedClient(string $file)
    {
        return Mockery::mock(Client::class, static function (MockInterface $mock) use ($file) {
            $mock->shouldReceive('request')->once()->andReturn(
                new Crawler(File::get(base_path("/tests/{$file}.txt")))
            );
        });
    }

    public function getSchedules()
    {
        return ConvertTimetableSource::GetAvailableSchedulesFromCrawler($this->getMockedClient('/Unit/Samples/html-snapshot')->request('GET', 'https://timetable.com'));
    }

    public function test_it_can_count_all_schedules()
    {
        $this->assertCount(14, $this->getSchedules()->get('schedules'));
    }

    public function test_it_has_starting_and_ending_time()
    {
        $this->assertEquals('16:00', $this->getSchedules()->get('schedules')->first()['starting_time']);
        $this->assertEquals('17:00', $this->getSchedules()->get('schedules')->first()['ending_time']);
    }
}
