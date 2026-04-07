<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('courses', CourseController::class);
Route::get('courses-trash', [CourseController::class, 'trash'])->name('courses.trash');
Route::post('courses/{course}/restore', [CourseController::class, 'restore'])->name('courses.restore');

Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('courses.lessons.index');
Route::get('courses/{course}/lessons/create', [LessonController::class, 'create'])->name('courses.lessons.create');
Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('courses.lessons.store');
Route::get('courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('courses.lessons.edit');
Route::put('courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('courses.lessons.update');
Route::delete('courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('courses.lessons.destroy');

Route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::get('enrollments/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
Route::post('enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
