<?php

namespace App\Timetable;

use Carbon\Carbon;
use Illuminate\Config\Repository;

class DateConversion
{
    /**
     * @param string $day
     * @return mixed
     */
    public static function dayStringToNumeric(string $day): mixed
    {
        return config('timetable.day_position.'.strtolower($day));
    }

    /**
     * @param array $schedule
     * @param array $meta
     * @return array
     */
    public static function timetableScheduleToCarbon(array $schedule, array $meta)
    {
        $matches = [];

        preg_match_all("/\d{1,2} [a-zA-Z]{3} \d{4}/", $meta['week'], $matches);

        $carbonStart = Carbon::parse($matches[0][0])->addRealDays(DateConversion::dayStringToNumeric($schedule['day_of_week']))->setTimeFromTimeString($schedule['starting_time'])->toDateTimeString();
        $carbonEnd = Carbon::parse($matches[0][0])->addRealDays(DateConversion::dayStringToNumeric($schedule['day_of_week']))->setTimeFromTimeString($schedule['ending_time'])->toDateTimeString();

        return ['start' => $carbonStart, 'end' => $carbonEnd];
    }
}
