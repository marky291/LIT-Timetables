<?php


namespace App\Timetable;

use App\Models\Course;
use App\Timetable\Parsers\ParseTimetable;
use App\Timetable\Exceptions\ReturnedBadResponseException;
use Illuminate\Support\Collection;
use Symfony\Component\BrowserKit\HttpBrowser;

class HttpTimetableRequests extends HttpBrowser
{
    /**
     * @param Course $course
     * @return Collection
     * @throws ReturnedBadResponseException
     */
    public function crawl(Course $course): Collection
    {
        $beforeTime = microtime(1);

        $html = parent::request('GET', $course->source());

        if ($this->getInternalResponse()->getStatusCode() !== 200) {
            throw new ReturnedBadResponseException('Response '. $this->getInternalResponse()->getStatusCode() . ' from ' . $course->source());
        }

        $parsed = ParseTimetable::GetAvailableSchedulesFromCrawler($html);

        $afterTime = microtime(1);

        $course->requests()->create([
            'response' => $this->getInternalResponse()->getStatusCode(),
            'time' => round(($afterTime - $beforeTime), 3),
            'link' => $course->source(),
            'meta' => $parsed['meta'],
            'mined' => $parsed->get('schedules'),
        ]);

        return $parsed;
    }
}
