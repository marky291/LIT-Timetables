<?php

namespace App\Timetable\Commands;

use App\Models\Course;
use App\Timetable\Converters\ConvertTimetableFilters;
use App\Timetable\Converters\ConvertTimetableSource;
use App\Timetable\Exceptions\ReturnedBadResponseException;
use App\Timetable\Jobs\CreateCourseSchedules;
use App\Timetable\Jobs\CreateDepartmentCourses;
use App\Timetable\Jobs\TimetableSourceSchedules;
use App\Timetable\TimetableSourceLinkCreator;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class DispatchTimetableCrawlers extends Command
{
    /**
     * @var TimetableSourceLinkCreator
     */
    private $linkCreator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl the LIT Course service for data and store it in our database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TimetableSourceLinkCreator $linkCreator)
    {
        parent::__construct();

        $this->linkCreator = $linkCreator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Migrating fresh database.');
        Artisan::call('migrate:fresh');
        $this->info('Fresh migration complete');

        $this->info('Retrieving Departments & Courses');
        CreateDepartmentCourses::dispatchNow(new ConvertTimetableFilters(Http::get(config('timetable.url.filter'))->body()));
        $this->info('Done.');

        do {
            $courses = Course::all();
        } while ($courses->count() === 0);
        $this->info($courses->count() . " courses retrieved, Now Dispatching Timetable Jobs!");

        $this->output->progressStart($courses->count()*Carbon::now()->week);

            for ($i=1; $i <= Carbon::now()->week; $i++)
            {
                foreach ($courses as $course)
                {
                    try {
                        CreateCourseSchedules::dispatch($course, $this->timetable($course, $i));
                    } catch (ReturnedBadResponseException $exception) {
                        $this->warn($exception->getMessage());
                    }
                    $this->output->progressAdvance();
                }
            }

        $this->output->progressFinish();
        $this->info('Dispatching Complete...');
    }

    /**
     * Create a timetable link for dispatching.
     */
    private function timetable(Course $course, int $weekNumber): string
    {
        return $this->linkCreator->setCourse($course)->setWeek($weekNumber)->generate();
    }
}
