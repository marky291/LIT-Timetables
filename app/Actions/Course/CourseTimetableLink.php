<?php

namespace App\Actions\Course;

use App\Models\Course;
use Lorisleiva\Actions\Concerns\AsAction;

class CourseTimetableLink
{
    use AsAction;

    public function handle(Course $course, int $week = null)
    {
        // The base of a timetable link is made up of the course identifier.
        $url = sprintf(config('services.lit.relay.timetable.route'), $course->identifier);

        // we can specify a week we want to return form the url.
        if ($week) {
            $url .= sprintf("&weeks=%s", $week);
        }

        return $url;
    }
}
