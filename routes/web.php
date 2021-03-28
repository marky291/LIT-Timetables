<?php

use App\Http\Controllers\TimetableController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function() {
    return view('dashboard');
})->name('homepage');

Route::get('/courses/{course}', [TimetableController::class, 'course'])->name('course');
Route::get('/lecturers/{lecturer}', [TimetableController::class, 'lecturer'])->name('lecturer');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
