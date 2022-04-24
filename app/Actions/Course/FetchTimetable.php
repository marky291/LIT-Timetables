<?php

namespace App\Actions\Course;

use App\Exceptions\CourseUrlReceivedBadStatusCode;
use App\Models\Course;
use App\Services\Parsers\ParseTimetableService;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\BrowserKit\HttpBrowser;
use \Illuminate\Support\Collection;

class FetchTimetable extends HttpBrowser
{
    use AsAction;

    public function handle(Course $course): Collection
    {
        $start    = microtime(1);
        $response = parent::request('GET', $course->timetableLink());

        if ($this->getInternalResponse()->getStatusCode() !== 200) {
            throw new CourseUrlReceivedBadStatusCode('Response '. $this->getInternalResponse()->getStatusCode().' from '.$course->timetableLink());
        }

        $parser = (new ParseTimetableService($response))->allSchedules();
        $finish = microtime(1);

        $course->requests()->create([
            'response' => $this->getInternalResponse()->getStatusCode(),
            'time' => round(($finish - $start), 3),
            'link' => $course->timetableLink(),
            'meta' => $parser['meta'],
            'mined' => $parser->get('schedules'),
        ]);

        return $parser;
    }
}
