<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeacherController;
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
    return view('home');
})->name('home');

Route::get('/classes', [TimetableController::class, 'showClasses'])->name('classes');
Route::get('/classrooms', [TimetableController::class, 'showClassrooms'])->name('classrooms');
Route::get('/subjects', [TimetableController::class, 'showSubjects'])->name('subjects');
Route::get('/teachers', [TimetableController::class, 'showTeachers'])->name('teachers');
Route::get('/lessons', [TimetableController::class, 'showLessons'])->name('lessons');
Route::get('/cards', [TimetableController::class, 'showCards'])->name('cards');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class,'listTables'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/seed-database', [DashboardController::class, 'seedDatabase'])->name('seedDatabase');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
