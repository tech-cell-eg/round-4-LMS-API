<?php

use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Categories\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructorController;

  Route::controller(AuthController::class)->group(function () {
      Route::post('register', 'register');
      Route::post('login', 'login');
      Route::post('logout', 'logout')->middleware('auth:sanctum');
      });



  Route::get('/user', function (Request $request) {
      return $request->user();
  })->middleware('auth:sanctum');

  Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
  Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
  Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);

  Route::post('/courses', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'is_instructor']);
  Route::get('/courses', [CourseController::class, 'index']);
  Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
  Route::get('/courses/{id}', [CourseController::class, 'show']);
  Route::get('/categories', [CategoryController::class, 'index']);


  Route::group(['middleware' => ['auth:sanctum']], function () {
      Route::get('/my-courses', [ProfileController::class, 'myCourses']);

      Route::get('instructors/{instructorUsername}', [InstructorProfileController::class, 'show']);

  });
