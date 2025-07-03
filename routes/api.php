<?php

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
    Route::get('/instructors/{instructor}/courses', [InstructorController::class, 'showInstructorCourses']);

