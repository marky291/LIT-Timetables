<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('courses/index');
    }

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
            'schedules' => $course->schedules()->latestAcademicWeek()->get(),
        ]);
    }
}
