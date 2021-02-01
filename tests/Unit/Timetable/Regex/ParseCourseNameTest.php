<?php

namespace Tests\Unit\Timetable\Regex;

use App\Timetable\Parsers\ParseCourseName;
use Tests\TestCase;

class ParseCourseNameTest extends TestCase
{
    public function test_is_has_an_identifier()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals('m_sltSmgmt4B', $regex->getIdentifier());
    }

    public function test_identifier_with_brackets()
    {
        $regex = new ParseCourseName('m_itSd4 (Entrepreneurship) - (Thurles) Higher Certificate in Marketing and Management (L6) - Year 2 Group B');

        $this->assertEquals('m_itSd4+%28Entrepreneurship%29', $regex->getIdentifier());
    }

    public function test_it_has_a_location()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals('Moylish', $regex->getLocation());
    }

    public function test_it_has_a_group()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals('B', $regex->getGroup());
    }

    public function test_it_has_a_year()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals(4, $regex->getYear());
    }

    public function test_it_has_a_name()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals('Business Studies with Sports Management - Year 4 Group B', $regex->getName());
    }

    public function test_it_can_return_array_of_items()
    {
        $regex = new ParseCourseName('m_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B');

        $this->assertEquals(['identifier' => 'm_sltSmgmt4B', 'location' => 'Moylish', 'group' => 'B', 'year' => '4', 'name' => 'Business Studies with Sports Management - Year 4 Group B', 'title' => 'm_sltSmgmt4B - (Moylish) Business Studies with Sports Management - Year 4 Group B'], $regex->toArray());
    }
}
