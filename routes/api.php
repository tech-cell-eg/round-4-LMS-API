<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);
Route::get('/instructors/{id}/courses', [InstructorController::class, 'showInstructorCourses']);
