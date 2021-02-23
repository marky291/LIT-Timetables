<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return Application|Factory|View|Response
     */
    public function show(Course $course)
    {
        return view('courses/show', [
            'course' => $course,
            'schedules' => $this->schedules($course),
        ]);
    }

    /**
     * Retrieve all the schedules belonging to a course
     *
     * @param Course $course
     * @return mixed
     */
    private function schedules(Course $course)
    {
        return Cache::remember($course->identifier . "_schedules", now()->addMinutes(30), function () use ($course) {
            return $course->schedules()->latestAcademicWeek()->with(['room', 'module', 'type', 'lecturers'])->get();
        });
    }
}
