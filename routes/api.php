<?php

use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SyllabusController;
use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Categories\CategoryController;
use App\Http\Controllers\Api\Instructor\InstructorController;
use App\Http\Controllers\CourseCustomerController;
// use App\Http\Controllers\Api\Student\CartController;
use App\Http\Controllers\InstructorController as ControllersInstructorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User info
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

  Route::get('/user', function (Request $request) {
      return $request->user();
  })->middleware('auth:sanctum');

  Route::post('/instructors/{instructor}/review', [ControllersInstructorController::class, 'store']);
  Route::get('/instructors/{instructor}/reviews', [ControllersInstructorController::class, 'index']);
  Route::get('/top-instructors', [ControllersInstructorController::class, 'topInstructors']);

  Route::post('/courses', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'is_instructor']);
  Route::get('/courses', [CourseController::class, 'index']);
  Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
  Route::get('/courses/{id}', [CourseController::class, 'show']);
  Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/courses/{course}/customers', [CourseCustomerController::class, 'index']);

Route::get('/instructors', [ControllersInstructorController::class, 'index']);
Route::get('/instructors/{instructor}', [ControllersInstructorController::class, 'show']);
Route::get('/instructors/{instructor}/courses', [ControllersInstructorController::class, 'showInstructorCourses']);
