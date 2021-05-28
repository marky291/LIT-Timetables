<?php

namespace App\Actions\Course;

use App\Exceptions\CourseUrlReceivedBadStatusCode;
use App\Models\Course;
use App\Timetable\Parsers\ParseTimetable;
use Lorisleiva\Actions\Concerns\AsAction;

class FetchSchedules
{
    use AsAction;

    public function handle(Course $course)
    {
        $beforeTime = microtime(1);

        $request = \Http::request('GET', $course->source());

        if ($request->getInternalResponse()->getStatusCode() !== 200) {
            throw new CourseUrlReceivedBadStatusCode('Response '. $request->getInternalResponse()->getStatusCode().' from '.$course->source());
        }

        $parsed = ParseTimetable::GetAvailableSchedulesFromCrawler($request);

        $afterTime = microtime(1);

        $course->requests()->create([
            'response' => $request->getInternalResponse()->getStatusCode(),
            'time' => round(($afterTime - $beforeTime), 3),
            'link' => $course->source(),
            'meta' => $parsed['meta'],
            'mined' => $parsed->get('schedules'),
        ]);

        return $parsed;
    }
}
