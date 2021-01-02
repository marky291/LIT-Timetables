<?php

namespace Tests\Unit;

use App\Timetable\Converters\ConvertTimetableSource;
use Goutte\Client;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

/**
 * Class TimetableSourceToArrayTest.
 */
class TimetableSourceToArrayTest extends TestCase
{
    private function getMockedClient(string $file)
    {
        return Mockery::mock(Client::class, static function (MockInterface $mock) use ($file) {
            $mock->shouldReceive('request')->once()->andReturn(
                new Crawler(File::get(base_path("/tests/Unit/{$file}.txt")))
            );
        });
    }

    public function test_it_can_count_all_schedules()
    {
        $timetable = ConvertTimetableSource::GetAvailableSchedulesFromCrawler($this->getMockedClient('Samples/html-snapshot')->request('GET', 'https://timetable.com'));

        $this->assertCount(14, $timetable->get('schedules'));
    }
}
