<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('lecturers/index', [
            'lecturers' => Lecturer::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Lecturer $lecturer)
    {
        return view('lecturers/show', [
            'lecturer' => $lecturer,
            'schedules' => $lecturer->schedules()->latestAcademicWeek()->get(),
        ]);
    }
}
