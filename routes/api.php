<?php

use App\Http\Resources\CourseCollection;
use App\Http\Resources\ScheduleCollection;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('courses', function () {
    return Cache::remember('courses:api', now()->hour(1), function () {
        return new CourseCollection(Course::with('department')->get());
    });
});

Route::get('course/{course}/schedules', function (Course $course) {
    return new ScheduleCollection($course->timetable->schedules);
});
