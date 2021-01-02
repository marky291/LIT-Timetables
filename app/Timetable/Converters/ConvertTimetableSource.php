<?php

namespace App\Timetable\Converters;

use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Scraped a timetable page.
 */
class ConvertTimetableSource
{
    /**
     * Create an associative table from the content table.
     *
     * @param Crawler $crawler
     * @return Collection
     */
    public static function GetAvailableSchedulesFromCrawler(Crawler $crawler): Collection
    {
        // storage for schedules.
        $schedules = new Collection();

        // collect timetable information...
        $rawTable = self::GetRawTableFromHTML($crawler);

        for ($i = 1, $iMax = count($rawTable); $i < $iMax; $i++) {
            if ($rawTable[$i]['rowspan'] > 1) {
                self::AssignMissingDayToRawTableData($rawTable[$i], $rawTable, $i);
            }

            if ($rawTable[$i]['rowspan']) {
                self::PushScheduleToCollection($schedules, $rawTable[0]['columns'], $rawTable[$i]);
            }
        }

        return collect([
            'meta' => self::GetRawTableMetaFromHtml($crawler),
            'schedules' => $schedules,
        ]);
    }

    /**
     * Crawl the html and get the meta data for the table.
     *
     * @param Crawler $crawler
     * @return array
     */
    private static function GetRawTableMetaFromHtml(Crawler $crawler)
    {
        return [
            'group' => $crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(1)>font')->text(),
            'department' => $crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(2)>font')->text(),
            'week' => $crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(1)>tr>td>table>tr>td:nth-child(3)>font')->text(),
        ];
    }

    /**
     * Generate an raw array from the crawling data.
     *
     * @param Crawler $crawler
     * @return array
     */
    private static function GetRawTableFromHTML(Crawler $crawler): array
    {
        $results = $crawler->filter('body>table>tr:nth-child(4)>td>table:nth-child(2)>tr')->each(function (Crawler $row, int $rowIndex) use (&$currentTime) {
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

        return $results;
    }

    /**
     * @param $row
     * @param array $rawTable
     * @param int $i
     */
    private static function AssignMissingDayToRawTableData($row, array &$rawTable, int $i): void
    {
        for ($j = 1; $j < $row['rowspan']; $j++) {
            array_unshift($rawTable[$i + $j]['columns'], $row['columns'][0]);
        }
    }

    /**
     * @param $row
     * @param Collection $schedules
     * @param array $times
     */
    private static function PushScheduleToCollection(Collection $schedules, array $times, $row): void
    {
        foreach (array_splice($row['columns'], 1) as $key => $value) {
            if (is_array($value)) {
                $schedules->push([
                    'module' => $value['module'],
                    'room' => $value['room'],
                    'lecturer' => $value['lecturer'],
                    'type' => $value['type'],
                    'day_of_week' => $row['columns'][0],
                    'starting_time' => self::getScheduleColumnPosition($value['starting_time']),
                    'ending_time' => self::getScheduleColumnPosition($value['ending_time']),
                ]);
            }
        }
    }

    private static function getScheduleColumnPosition(int $column_position)
    {
        return now()->setTime(config('timetable.time.starting_hour'), 0, 0, 0)->addMinutes(config('timetable.time.increment_minutes') * ($column_position - 1))->format('H:i');
    }
}
