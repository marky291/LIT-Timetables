<?php

namespace App\Console\Commands;

use App\Actions\Course\SynchronizeSchedule;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use App\Models\Synchronization;
use App\Exceptions\CourseMissingLocation;
use App\Services\Parsers\ParseCourseNameService;
use App\Services\Parsers\ParseFilterService;
use App\Services\SemesterPeriodDateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RelaySyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relay:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronization the data of the application with the LIT Timetable Domain.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->info('Build started for timetable data.');

        /**
         * We allow a hardcoded week to be defined for demo/test purposes.
         */
        if (config('services.lit.relay.timetable.week')) {
            $this->comment("[Config]: Crawler is set to crawl week '" . config('services.lit.relay.timetable.week') . "'.");
        }

        /**
         * The LIT web domain that stores the data we can harvest
         * to create the departments and course lookup data.
         */
        $filter = new ParseFilterService(Str::of(Http::get(config('services.lit.relay.data'))->body()));

        /**s
         * Get all the departments in the filter, map to an array
         * and save into database if it does not exist.
         */
        $output = $this->output;
        $output->progressStart($filter->departments()->count());
        $filter->departments()->map(fn ($data) => get_object_vars($data))->each(function ($attributes) use ($output) {
            Department::firstOrCreate($attributes);
            $output->progressAdvance();
        });
        $output->progressFinish();

        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->comment('Stored '.Department::count().' out of '.$filter->departments()->count().' departments.');
        $this->info('Collecting course data and their associated campuses.');

        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist.
         */
        $output = $this->output;
        $output->progressStart($filter->courses()->unique('slug')->count());
        $filter->courses()->unique('slug')->each(function ($value) use (&$output) {
            $data = (new ParseCourseNameService(Str::of($value->name)));
            try {
                Course::firstOrCreate(['identifier' => $data->getIdentifier()], array_merge($data->toArray(), [
                    'campus_id' => Campus::firstOrCreate(['location' => $data->getLocation()])->id,
                    'department_id' => Department::firstWhere('filter', $value->filter)->id,
                ]));
            } catch (CourseMissingLocation $e) {
                Log::error("Missing course data in course title {$value->name}.");
            } finally {
                $output->progressAdvance();
            }
        });
        $output->progressFinish();

        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->comment('Stored '.Course::count().' out of '.$filter->courses()->count().' courses belonging to '.Campus::count().' campuses.');
        $this->info('Collecting course schedules.');

        /**
         * We do have the ability to get x amount of timetables
         * for a course in the future, so we will define that
         * count for the progress bar and looping.
         */
        $weeks_to_fetch = config('services.lit.relay.weeks_to_fetch');
        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist. We use the semester period
         * date service to get the current semester period.
         */
        $output = $this->output;
        $course = Course::all();
        $output->progressStart($course->count() * $weeks_to_fetch);

        // Get the current semester period.
        $current_week = app(SemesterPeriodDateService::class)->week();

        // override for demo purposes.
        if (config('services.lit.relay.timetable.week')) {
            $current_week = config('services.lit.relay.timetable.week');
        }

        // we need to get both this weeks information and next weeks
        // to allow users to browse future and past schedules.
        // since past schedules would already be stored we
        // only need to get the next weeks information.
        $course->each(function (Course $course) use ($output, $current_week, $weeks_to_fetch) {
            for ($i=0; $i < $weeks_to_fetch; $i++) {
                SynchronizeSchedule::dispatch($course, $current_week + $i);
                $output->progressAdvance(1);
            }
            $output->progressAdvance(1);
        });

        /**
         * comments that bring happiness.
         */
        $this->comment('Schedules have been dispatched successfully to threads.');

        /**
         * Store a synchronization log in model format.
         */
        (new Synchronization)->save();

        /**
         * Clear caches, because things prob changed!
         */
        $this->call('cache:clear');

        /**
         * Notify the dev
         */
        $this->info('Completed Timetable Synced Successfully.');

        /**
         * Let the command know it succeeded.
         */
        return false;
    }
}
