<?php

namespace App\Services\Parsers;

use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Scraped a timetable page.
 */
class ParseTimetableService
{
    public function __construct(
        public Crawler $crawler
    ) {
    }

    public function allSchedules(): Collection
    {
        // storage for schedules.
        $schedules = new Collection();

        // collect timetable information...
        $rawTable = $this->crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(2)>tr')->each(function (Crawler $row, int $rowIndex) use (&$currentTime) {
            $timetracking = 1;

            return [
                'rowspan' => $row->filter('td')->first()->attr('rowspan'),
                'columns' => $row->children()->each(function (Crawler $col, int $colIndex) use ($rowIndex, &$timetracking) {
                    if ($rowIndex == 0) {
                        return $col->text();
                    }

                    if ($colIndex == 0) {
                        return $col->text();
                    }

                    if ($col->attr('colspan')) {
                        return [
                            'module'   => $col->filter('font')->eq(0)->text(),
                            'room'     => $col->filter('font')->eq(1)->text(),
                            'lecturer' => $col->filter('font')->eq(3)->text(),
                            'type'     => $col->filter('font')->eq(2)->text(),
                            'starting_time' => $timetracking,
                            'ending_time' => $timetracking += $col->attr('colspan'),
                        ];
                    }

                    $timetracking++;

                    return ' ';
                }),
            ];
        });

        for ($i = 1, $iMax = count($rawTable); $i < $iMax; $i++) {
            if ($rawTable[$i]['rowspan'] > 1) {
                for ($j = 1; $j < $rawTable[$i]['rowspan']; $j++) {
                    array_unshift($rawTable[$i + $j]['columns'], $rawTable[$i]['columns'][0]);
                }
            }

            if ($rawTable[$i]['rowspan']) {
                foreach (array_splice($rawTable[$i]['columns'], 1) as $key => $value) {
                    if (is_array($value)) {
                        $schedules->push([
                            'module' => $value['module'],
                            'room' => $value['room'],
                            'lecturer' => $value['lecturer'],
                            'type' => $value['type'],
                            'day_of_week' => $rawTable[$i]['columns'][0],
                            'starting_time' => $this->carbonFromColumn($value['starting_time']),
                            'ending_time' => $this->carbonFromColumn($value['ending_time']),
                        ]);
                    }
                }
            }
        }

        return collect([
            'meta' => [
                'group' => $this->crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(1)>font')->text(),
                'department' => $this->crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(2)>font')->text(),
                'week' => $this->crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(3)>font')->text(),
            ],
            'schedules' => $schedules,
        ]);
    }

    private function carbonFromColumn(int $column_position): string
    {
        return now()->setTime(8, 0, 0, 0)->addMinutes(30 * ($column_position - 1))->format('H:i');
    }
}
