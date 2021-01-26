<?php

namespace Tests\Unit\Timetable\Jobs;

use App\Models\Course;
use App\Models\Requests;
use App\Models\Schedule;
use App\Models\Timetable;
use App\Timetable\Commands\SyncTimetableCommand;
use App\Timetable\Events\ScheduledDayHasChanged;
use App\Timetable\Events\ScheduledLecturerHasChanged;
use App\Timetable\Events\ScheduledModuleHasChanged;
use App\Timetable\Events\ScheduledRoomHasChanged;
use App\Timetable\Events\ScheduledTimeHasChanged;
use App\Timetable\Events\ScheduledTypeHasChanged;
use App\Timetable\Events\TimetableFetchFailed;
use App\Timetable\Events\TimetableFetchSuccesfully;
use App\Timetable\Events\TimetableWasChanged;
use App\Timetable\Jobs\FetchWeekSchedules;
use Goutte\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Mockery;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class FetchTimetableWeekScheduleTest extends TestCase
{
    use RefreshDatabase;

    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);

        $this->course = Course::factory()->create();
    }

    public function test_stored_schedule_has_starting_date()
    {
        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200);
        $this->client->shouldReceive('getInternalResponse->getHeader')->andReturn(File::size(base_path('/tests/Unit/Samples/html-snapshot-2.txt')));
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot-2.txt'))));

        $this->createTimetableScheduleFrom($this->client);

        $this->assertEquals('2020-10-20 16:00:00', Schedule::first()->starting_date);
    }

    public function test_stored_schedule_has_ending_date()
    {
        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200);
        $this->client->shouldReceive('getInternalResponse->getHeader')->andReturn(File::size(base_path('/tests/Unit/Samples/html-snapshot-2.txt')));
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot-2.txt'))));

        $this->createTimetableScheduleFrom($this->client);

        $this->assertEquals('2020-10-20 17:00:00', Schedule::first()->ending_date);
    }

    public function test_timetable_stores_mined_scheduled_as_attribute_array()
    {
        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200);
        $this->client->shouldReceive('getInternalResponse->getHeader')->andReturn(File::size(base_path('/tests/Unit/Samples/html-snapshot.txt')));
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))));
        $this->createTimetableScheduleFrom($this->client);

        $this->assertCount(14, Requests::first()->mined);
    }

    public function test_changed_timetable_creates_event()
    {
        $this->expectsEvents(TimetableWasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot-2.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_module_event()
    {
        $this->expectsEvents(ScheduledModuleHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/ModuleChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_room_event()
    {
        $this->expectsEvents(ScheduledRoomHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/RoomChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_lecturer_event()
    {
        $this->expectsEvents(ScheduledLecturerHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/LecturerChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_type_event()
    {
        $this->expectsEvents(ScheduledTypeHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/TypeChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_day_of_week_event()
    {
        $this->expectsEvents(ScheduledDayHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/DayChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_create_changed_time_event()
    {
        $this->expectsEvents(ScheduledTimeHasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(3);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/Modified/TimeChanged.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_unchanged_timetable_does_not_create_event()
    {
        $this->doesntExpectEvents(TimetableWasChanged::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->times(4);
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->twice();
        $this->createTimetableScheduleFrom($this->client);
        $this->createTimetableScheduleFrom($this->client);
    }

    public function test_timetable_course_fetched_succesfully()
    {
        $this->expectsEvents(TimetableFetchSuccesfully::class);

        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->twice();
        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path('/tests/Unit/Samples/html-snapshot.txt'))))->once();
        $this->createTimetableScheduleFrom($this->client);
    }

//    public function test_timetable_course_fetched_failed()
//    {
//        $this->expectsEvents(TimetableFetchFailed::class);
//
//        $this->client->shouldReceive('getInternalResponse->getStatusCode')->andReturn(200)->once();
//        $this->client->shouldReceive('request')->once()->andReturn(new Crawler(File::get(base_path("/tests/Samples/html-snapshot.txt"))))->once();
//        $this->createTimetableScheduleFrom($this->client);
//    }

    private function createTimetableScheduleFrom(Client $client)
    {
        (new FetchWeekSchedules($this->course, 'Faker'))->handle($client);
    }
}
