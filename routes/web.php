<?php

use App\Http\Controllers\TimetableController;
use App\Timetable\Mail\SubscribedToTimetable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/mail', function() {
    return new SubscribedToTimetable(1, \App\Models\Course::find(1));
});

Route::get('/', function() {
    return view('homepage');
})->name('homepage');

Route::get('/courses/{course}', [TimetableController::class, 'course'])->name('course');
Route::get('/lecturers/{lecturer}', [TimetableController::class, 'lecturer'])->name('lecturer');
