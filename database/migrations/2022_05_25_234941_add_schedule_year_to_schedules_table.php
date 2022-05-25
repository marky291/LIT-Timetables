<?php

use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleYearToSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('schedule_year')->after('id')->nullable();
        });

        Schedule::chunk(1000, function ($schedules) {
            foreach ($schedules as $schedule) {
                $schedule->schedule_year = $schedule->academic_year;

                if ($schedule->academic_year <= app(SemesterPeriodDateService::class)->weeksInFirstPeriod()) {
                    $schedule->schedule_year = $schedule->academic_year + 1; // add another year because they will graduate then...
                }

                $schedule->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            //
        });
    }
}
