<?php

namespace App\Services\Parsers;

use Illuminate\Support\Stringable;
use JetBrains\PhpStorm\ArrayShape;

class ParseCourseNameService
{
    public function __construct(
        public Stringable $name
    ) {
    }

    public function getIdentifier(): string
    {
        return urlencode($this->name->match('/(.*?)(?= -)/'));
    }

    public function getLocation(): string
    {
        return $this->name->match("/(?<=\()(Moylish|Thurles|Ennis|Clonmel)(?=\))/");
    }

    public function getGroup(): string
    {
        return $this->name->match("/(?<=\sGroup )(\w)/");
    }

    public function getYear(): string
    {
        return $this->name->match("/(?<=\sYear )(\d)/");
    }

    public function getName(): string
    {
        return $this->name->match("/(?<=\({$this->getLocation()}\) )(.+)/");
    }

    #[ArrayShape(['identifier' => 'string', 'location' => 'string', 'group' => 'string', 'year' => 'string', 'name' => 'string', 'title' => "\Illuminate\Support\Str"])]
    public function toArray(): array
    {
        return [
            'identifier' => $this->getIdentifier(),
            'location'   => $this->getLocation(),
            'group'      => $this->getGroup(),
            'year'       => $this->getYear(),
            'name'       => $this->getName(),
            'title'      => $this->name,
        ];
    }
}
