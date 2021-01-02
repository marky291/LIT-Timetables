<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LecturerController;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('courses', CourseController::class)->only([
    'index', 'show',
]);

Route::resource('lecturers', LecturerController::class)->only([
    'index', 'show',
]);
