<?php

use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SyllabusController;
use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Categories\CategoryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CartController;
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

// Instructors Routes
Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);

// Courses Routes
Route::post('/courses', [CourseController::class, 'store'])->middleware(['auth:sanctum', 'is_instructor']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
Route::get('/courses/{id}', [CourseController::class, 'show']);
Route::get('/courses/{slug}', [CourseController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Syllabus
Route::get('courses/{courseId}/syllabuses', [SyllabusController::class, 'index']);

// Reviews on Courses
Route::prefix('courses/{courseId}/reviews')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::get('/{reviewId}', 'show')->middleware('auth:sanctum');
    Route::put('/{reviewId}', 'update')->middleware('auth:sanctum');
    Route::delete('/{reviewId}', 'destroy')->middleware('auth:sanctum');
});

// Student Profile Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('instructors/{instructorUsername}', [InstructorProfileController::class, 'show'])->name('instructor.show');
    Route::get('/profile/my-courses', [ProfileController::class, 'myCourses']);
    Route::get('/my-instructors', [ProfileController::class, 'myInstructors']);
    Route::get('/my-reviews', [ProfileController::class, 'myReviews']);
    Route::get('/my-chats', [ProfileController::class, 'myChats']);
    Route::get('/my-chats/{chatId}', [ProfileController::class, 'GetMessages']);
});

// Cart routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{course_id}', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    Route::get('/cart/my-courses', [CartController::class, 'registeredCourses']);
});
