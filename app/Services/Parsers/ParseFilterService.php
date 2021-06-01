<?php

namespace App\Services\Parsers;

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

/**
 * Mainly scraped @filter.js from lit timetable service.
 */
class ParseFilterService
{
    public function __construct(
        public Stringable $content
    ) {}

    public function departments(): Collection
    {
        return $this->fetchJavascriptArray('deptarray', ['name' => 0, 'filter' => 1]);
    }

    public function modules(): Collection
    {
        return $this->fetchJavascriptArray('modulearray', ['name' => 0, 'filter' => 1, 'slug' => 2]);
    }

    public function courses(): Collection
    {
        return $this->fetchJavascriptArray('studsetarray', ['name' => 0, 'filter' => 1, 'slug' => 2]);
    }

    private function fetchJavascriptArray(string $pattern, array $generator = []): Collection
    {
        $scraper = new Collection();

        // create matches, singular arrays.
        foreach ($generator as $name => $position) {
            $scraper->put($name, $this->content->matchAll("/\b$pattern\[\d+\] \[$position\] = \"(.*?)\"/"));
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
}
