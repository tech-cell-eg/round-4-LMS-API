<?php

use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

  Route::post('/courses', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'is_instructor']);
  Route::get('/courses', [CourseController::class, 'index']); 
  Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
  Route::get('/courses/{id}', [CourseController::class, 'show']);