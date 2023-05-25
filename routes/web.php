<?php

use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/welcome', [TimetableController::class, 'welcome'])->name('welcome');
//Route::get('/timetable/cards', [TimetableController::class, 'showCards']);
Route::get('/cards', [TimetableController::class, 'showCards'])->name('cards');
//Route::get('/timetable/classes', [TimetableController::class, 'showClasses']);
Route::get('/classes', [TimetableController::class, 'showClasses'])->name('classes');
//Route::get('/timetable/classrooms', [TimetableController::class, 'showClassrooms']);
Route::get('/classrooms', [TimetableController::class, 'showClassrooms'])->name('classrooms');
//Route::get('/timetable/days', [TimetableController::class, 'showDaysdefs']);
Route::get('/days', [TimetableController::class, 'showDaysdefs'])->name('days');
//Route::get('/timetable/grades', [TimetableController::class, 'showGrades']);
Route::get('/grades', [TimetableController::class, 'showGrades'])->name('grades');
//Route::get('/timetable/groups', [TimetableController::class, 'showGroups']);
Route::get('/groups', [TimetableController::class, 'showGroups'])->name('groups');
//Route::get('/timetable/lessons', [TimetableController::class, 'showLessons']);
Route::get('/lessons', [TimetableController::class, 'showLessons'])->name('lessons');
//Route::get('/timetable/periods', [TimetableController::class, 'showPeriods']);
Route::get('/periods', [TimetableController::class, 'showPeriods'])->name('periods');
//Route::get('/timetable/subjects', [TimetableController::class, 'showSubjects']);
Route::get('/subjects', [TimetableController::class, 'showSubjects'])->name('subjects');
//Route::get('/timetable/teachers', [TimetableController::class, 'showTeachers']);
Route::get('/teachers', [TimetableController::class, 'showTeachers'])->name('teachers');
//Route::get('/timetable/terms', [TimetableController::class, 'showTermsdefs']);
Route::get('/terms', [TimetableController::class, 'showTermsdefs'])->name('terms');
//Route::get('/timetable/weeks', [TimetableController::class, 'showWeeksdefs']);
Route::get('/weeks', [TimetableController::class, 'showWeeksdefs'])->name('weeks');

