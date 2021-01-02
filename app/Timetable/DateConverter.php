<?php


namespace App\Timetable;


class DateConverter
{
    public static function convertShorthandDateToInt(string $day)
    {
        return config("timetable.day_position." . strtolower($day));
    }
}
