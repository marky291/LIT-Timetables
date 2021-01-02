<?php

namespace App\Timetable;

use App\Models\Course;

class TimetableSourceLinkCreator
{
    private $course;
    private $weekNumber;

    public function setCourse(Course $course): self
    {
        $this->course = $course->identifier;

        return $this;
    }

    public function setWeek(int $weekNumber): self
    {
        $this->weekNumber = $weekNumber;

        return $this;
    }

    public function generate(): string
    {
        if (is_numeric($this->weekNumber)) {
            return sprintf(config('timetable.url.source'), $this->course, "&weeks={$this->weekNumber}");
        }

        return sprintf(config('timetable.url.source'), $this->course, '');
    }
}
