<?php

use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('academic_year')->index()->after('id')->nullable();
        });

        $console = new ConsoleOutput();

        Schedule::all()->chunk(250)->each(function ($schedules) use ($console) {
            foreach ($schedules as $schedule) {
                $schedule->academic_year = $schedule->starting_date->year;
                $schedule->save();
            }
            $console->writeln('Completed a chunk of 250 items.');
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
            $table->drop('academic_year');
        });
    }
};
