<?php

use App\Http\Resources\Campus as CampusResource;
use App\Http\Resources\Course as CourseResource;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Schedule;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('campus', function () {
    return Cache::remember('campus', now()->hour(1), function () {
        return CampusResource::collection(Campus::all());
    });
});

Route::get('courses', function () {
    return Cache::remember('courses:api', now()->hour(1), function () {
        return new CourseCollection(Course::with('department')->get());
    });
});

Route::get('campus/{campus}/course', function (Request $request, $campus_id) {
    return Cache::remember("{$campus_id}.courses", now()->hour(1), function () use ($campus_id) {
        return CourseResource::collection(Course::with('department')->where('campus_id', $campus_id)->get());
    });
});

Route::get('/courses/{course_id}/schedules/week/{week}', function ($course_id, $week) {
    return Cache::remember("CourseSchedule_{$course_id}_{$week}", now()->hour(1), function () use ($course_id, $week) {
        $course = Course::findOrFail($course_id)->schedules()->whereWeek($week)->get();
        return ScheduleResource::collection($course);
    });
});

// Route::get('course/{course}/schedules', function (Course $course) {
//     return new ScheduleCollection($course->timetable->schedules);
// });
