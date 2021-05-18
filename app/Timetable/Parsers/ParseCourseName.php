<?php

namespace App\Timetable\Parsers;

use App\Exceptions\CourseMissingLocationData;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class ParseCourseName
{
    /**
     * @var string
     */
    private $title;

    public function __construct(string $title)
    {
        $this->title = Str::of($title);
    }

    private function regResult(string $expression, string $string)
    {
        return Regex::match($expression, $string)->result();
    }

    public function getIdentifier()
    {
        return urlencode($this->regResult('/(.*?)(?= -)/', $this->title));
    }

    /**
     * @return string
     * @throws CourseMissingLocationData
     */
    public function getLocation()
    {
        $available = implode('|', ['Moylish', 'Thurles', 'Ennis', 'Clonmel']);

        $location = $this->regResult("/(?<=\()($available)(?=\))/", $this->title);

        if (empty($location)) {
            throw new CourseMissingLocationData($this->title);
        }

        return $location;
    }

    public function getGroup()
    {
        return $this->regResult("/(?<=\sGroup )(\w)/", $this->title);
    }

    public function getYear()
    {
        return $this->regResult("/(?<=\sYear )(\d)/", $this->title);
    }

    public function getName()
    {
        return $this->regResult("/(?<=\({$this->getLocation()}\) )(.+)/", $this->title);
    }

    public function toArray()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'location'   => $this->getLocation(),
            'group'      => $this->getGroup(),
            'year'       => $this->getYear(),
            'name'       => $this->getName(),
            'title'      => $this->title,
        ];
    }
}
