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
            ->addRealDays($this->dayOfWeek(strtolower($day)))
            ->setTimeFromTimeString($time);
    }

    private function dayOfWeek(string $day) : int
    {
        switch ($day) {
            case 'mon': return 0;
            case 'tue': return 1;
            case 'wed': return 2;
            case 'thu': return 3;
            case 'fri': return 4;
            case 'sat': return 5;
            case 'sun': return 6;
        }
    }
}
