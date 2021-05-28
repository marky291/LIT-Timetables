<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SemesterPeriodDateService
{
    /**
     * @var Carbon
     */
    private Carbon $currentDate;

    /**
     * SemesterPeriods constructor.
     *
     * @param Carbon $currentDate
     */
    public function __construct(Carbon $currentDate)
    {
        $this->currentDate = $currentDate;
    }

    /**
     * @return Collection
     */
    public function firstPeriod(): Collection
    {
        return $this->createPeriodFrom('timetable.semester.first.start', 'timetable.semester.first.end');
    }

    /**
     * @return Collection
     */
    public function secondPeriod(): Collection
    {
        return $this->createPeriodFrom('timetable.semester.second.start', 'timetable.semester.second.end');
    }

    /**
     * @param string $config_start
     * @param string $config_finish
     * @return Collection
     */
    private function createPeriodFrom(string $config_start, string $config_finish): Collection
    {
        $start = $this->parse(Str::of(config($config_start))->append(' ')->append($this->currentDate->year));
        $finish = $this->parse(Str::of(config($config_finish))->append(' ')->append($this->currentDate->year));

        // if current date is less than the configuration date, then it must be last year;
        if ($this->currentDate < $start) {
            $start->subYear(1);
            $finish->subYear(1);
        } elseif ($this->currentDate > $finish) {
            $start->addYear(1);
            $finish->addYear(1);
        }

        return collect(['start' => $start, 'finish' => $finish]);
    }

    /**
     * Parse a date string to carbon.
     *
     * @param $date
     * @return Carbon
     */
    private function parse($date): Carbon
    {
        return Carbon::parse($date);
    }

    /**
     * Useful to know the current week into the semester.
     *
     * @return int
     */
    public function week()
    {
        return $this->currentDate->diffInWeeks($this->firstPeriod()->get('start'));
    }

    /**
     * Get the current semester number of the semester (2 total)
     *
     * @return int
     */
    public function semester(): int
    {
        return $this->currentDate->gt($this->secondPeriod()['start']) ? 2 : 1;
    }
}
