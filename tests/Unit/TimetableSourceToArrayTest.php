<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Support\Facades\Date;
use Mockery;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Support\Facades\File;
use App\Timetable\Converters\ConvertTimetableSource;

/**
 * Class TimetableSourceToArrayTest
 *
 * @package Tests\Unit
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
