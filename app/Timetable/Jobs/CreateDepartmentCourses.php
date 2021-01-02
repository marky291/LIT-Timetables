<?php

namespace App\Timetable\Jobs;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use App\Timetable\Converters\ConvertTimetableFilters;
use App\Timetable\Exceptions\UnknownCourseLocationException;
use App\Timetable\Regex\RegexDataFromCourseName;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class CreateDepartmentCourses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * @var ConvertTimetableFilters
     */
    private $decoder;

    /**
     * @var Collection
     */
    private $departments;

    /**
     * Create a new job instance.
     *
     * @param ConvertTimetableFilters $decoder
     */
    public function __construct(ConvertTimetableFilters $decoder)
    {
        $this->departments = new Collection([]);

        $this->decoder = $decoder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // create departments if they do not exist already.
        foreach ($this->decoder->departments() as $scraped_course) {
            $this->departments->add(Department::firstOrCreate(get_object_vars($scraped_course)));
        }

        // create campus and cources associated with department
        foreach ($this->decoder->courses()->unique('slug')->all() as $index => $scraped_course) {
            try {
                DB::transaction(function () use ($scraped_course) {
                    $regex = $this->getRegexFromValue($scraped_course);
                    $campus = Campus::firstOrCreate(['location' => $regex->getLocation()]);
                    Course::where('identifier', $regex->getIdentifier())->firstOr(function () use ($regex, $campus, $scraped_course) {
                        $course = Course::make($regex->toArray());
                        $course = $course->campus()->associate($campus);
                        $dept = $this->departments->firstWhere('filter', $scraped_course->filter);
                        $course = $course->department()->associate($dept);
                        $course->save();
                    });
                });
            } catch (UnknownCourseLocationException $e) {
                Log::info($e->getMessage());
            }
        }
    }

    private function getRegexFromValue(stdClass $arrayObj)
    {
        $regex = (new RegexDataFromCourseName($arrayObj->name));

        if ($regex->getLocation() == null) {
            throw new UnknownCourseLocationException("Unable to determine location for course {$arrayObj->name}");
        }

        return $regex;
    }
}
