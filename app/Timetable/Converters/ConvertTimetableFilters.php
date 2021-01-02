<?php

namespace App\Timetable\Converters;

use Illuminate\Support\Collection;

/**
 * Mainly scraped @filter.js from lit timetable service.
 */
class ConvertTimetableFilters
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function departments(): Collection
    {
        return $this->getEntries('deptarray', ['name' => 0, 'filter' => 1]);
    }

    public function modules(): Collection
    {
        return $this->getEntries('modulearray', ['name' => 0, 'filter' => 1, 'slug' => 2]);
    }

    public function courses(): Collection
    {
        return $this->getEntries('studsetarray', ['name' => 0, 'filter' => 1, 'slug' => 2]);
    }

    /**
     * @param string $pattern
     * @param array $generator
     * @return Collection
     */
    private function getEntries(string $pattern, array $generator = [])
    {
        $scraper = new Collection();

        // create matches, singular arrays.
        foreach ($generator as $name => $position) {
            $scraper->put($name, $this->getAllMatches($pattern, $position));
        }

        $entries = new Collection();

        // create multi-dimentional array, not singular.
        for ($i = 0; $i < count($scraper[$scraper->keys()->first()]); $i++) {
            $std = new \stdClass();
            for ($j = 0; $j < count($scraper->keys()); $j++) {
                $std->{$scraper->keys()[$j]} = $scraper->get($scraper->keys()[$j])[$i];
            }
            $entries->add($std);
        }

        return $entries;
    }

    /**
     * @param string $pattern
     * @param int $position
     * @return mixed
     */
    private function getAllMatches(string $pattern, int $position)
    {
        $matches = [];
        preg_match_all("/\b".$pattern."\[\d+\] \[".$position."\] = \"(.*?)\"/", $this->content, $matches);

        return $matches[1];
    }
}
