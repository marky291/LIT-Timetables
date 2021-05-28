<?php

namespace App\Actions\Course;

use App\Exceptions\CourseUrlReceivedBadStatusCode;
use App\Models\Course;
use App\Timetable\Parsers\ParseTimetable;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\BrowserKit\HttpBrowser;
use \Illuminate\Support\Collection;

class FetchSchedules extends HttpBrowser
{
    use AsAction;

    public function handle(Course $course): Collection
    {
        $start = microtime(1);

        $response = parent::request('GET', $course->source());

        if ($this->getInternalResponse()->getStatusCode() !== 200) {
            throw new CourseUrlReceivedBadStatusCode(
                'Response '. $this->getInternalResponse()->getStatusCode().' from '.$course->source()
            );
        }

        $parsed = ParseTimetable::GetAvailableSchedulesFromCrawler($response);

        $finish = microtime(1);

        $course->requests()->create([
            'response' => $this->getInternalResponse()->getStatusCode(),
            'time' => round(($finish - $start), 3),
            'link' => $course->source(),
            'meta' => $parsed['meta'],
            'mined' => $parsed->get('schedules'),
        ]);

        return $parsed;
    }
}
