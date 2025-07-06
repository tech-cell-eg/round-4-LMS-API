<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Api\Student\CartController;
use App\Http\Controllers\Api\Student\CategoryController;
use App\Http\Controllers\Api\Student\CourseController;
use App\Http\Controllers\Api\Student\InstructorController;
use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\ReviewController;
use App\Http\Controllers\Api\Student\SyllabusController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});


// Instructor Routes
Route::group(['middleware' => ['auth:sanctum','is_instructor']], function () {
    Route::post('/courses', [InstructorCourseController::class, 'store']);
    Route::get('/courses/{slug}', [CourseController::class, 'show']);

});


//Student Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Student Profile Routes
    Route::get('instructors/{instructorUsername}', [InstructorProfileController::class, 'show'])->name('instructor.show');
    Route::get('/my-courses', [ProfileController::class, 'myCourses']);
    Route::get('/my-instructors', [ProfileController::class, 'myInstructors']);
    Route::get('/my-reviews', [ProfileController::class, 'myReviews']);
    Route::get('/my-chats', [ProfileController::class, 'myChats']);
    Route::get('/my-chats/{chatId}', [ProfileController::class, 'GetMessages']);

    // Courses Routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);

    // Cart routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{course_id}', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    Route::get('/cart/my-courses', [CartController::class, 'registeredCourses']);

    // Reviews on Courses
    Route::prefix('courses/{courseId}/reviews')->controller(ReviewController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{reviewId}', 'show');
        Route::put('/{reviewId}', 'update');
        Route::delete('/{reviewId}', 'destroy');


        // Instructors Routes
        Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
        Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
        Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);

    });

    // Syllabus
    Route::get('courses/{courseId}/syllabuses', [SyllabusController::class, 'index']);

});
