<?php

namespace App\Actions\Schedule;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class TransformDateToCarbon
{
    use AsAction;

    public function handle(string $schedule_week, string $day, string $time) : Carbon
    {
        $matches = [];

        preg_match_all("/\d{1,2} [a-zA-Z]{3} \d{4}/", $schedule_week, $matches);

        return Carbon::parse($matches[0][0])
            ->addRealDays(config('timetable.day_position.'.strtolower($day)))
            ->setTimeFromTimeString($time);
    }
}
