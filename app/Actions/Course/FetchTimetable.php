<?php

namespace App\Actions\Course;

use App\Exceptions\CourseUrlReceivedBadStatusCode;
use App\Models\Course;
use App\Services\Parsers\ParseTimetableService;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\BrowserKit\HttpBrowser;

class FetchTimetable extends HttpBrowser
{
    use AsAction;

    public function handle(Course $course, string $timetable_link): Collection
    {
        $start = microtime(1);
        $response = parent::request('GET', $timetable_link);

        if ($this->getInternalResponse()->getStatusCode() !== 200) {
            throw new CourseUrlReceivedBadStatusCode('Response '.$this->getInternalResponse()->getStatusCode().' from '.$timetable_link);
        }

        $parser = (new ParseTimetableService($response))->allSchedules();
        $finish = microtime(1);

        $course->requests()->create([
            'response' => $this->getInternalResponse()->getStatusCode(),
            'time' => round(($finish - $start), 3),
            'link' => $timetable_link,
            'meta' => $parser['meta'],
            'mined' => $parser->get('schedules'),
        ]);

        return $parser;
    }
}
