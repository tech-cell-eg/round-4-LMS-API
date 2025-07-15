<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DashCoursesController;
use App\Http\Controllers\Dashboard\DAuthController;
use App\Http\Controllers\Dashboard\HomeController;

// Welcome and home pages
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});




// Routes for instructor
Route::prefix('instructor')->name('instructor.')->group(function () {

    // login form
    Route::get('/login', [DAuthController::class, 'showLoginForm'])->name('login');

    // login post
    Route::post('/login', [DAuthController::class, 'login'])->name('login.post');

    // logout
    Route::post('/logout', [DAuthController::class, 'logout'])->name('logout');

    // authenticated routes
    Route::middleware(['auth:instructor', 'is_instructor'])->group(function () {

        // instructor dashboard
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });
});



Route::middleware(['auth:instructor'])->prefix('instructor')->group(function () {
    
    // عرض كورسات المحاضر
    Route::get('/courses', [DashCoursesController::class, 'InstructorCourses'])
        ->name('courses.instructorcourse');

    // عرض صفحة إنشاء كورس
    Route::get('/courses/create', [DashCoursesController::class, 'create'])
        ->name('courses.create');

    // تخزين الكورس
    Route::post('/courses', [DashCoursesController::class, 'store'])
        ->name('courses.store');


    Route::get('/commissions', [DashCoursesController::class, 'commissionReport'])
    ->name(name: 'courses.commissions');
    

    Route::get('/instructor/dashboard', [HomeController::class, 'dashboard'])
        ->name('instructor.dashboard');
        
    Route::get('/reviews', [App\Http\Controllers\Dashboard\DashCoursesController::class, 'reviews'])
    ->name('courses.reviews');

    Route::get('/customer', [App\Http\Controllers\Dashboard\DashCoursesController::class, 'customers'])
    ->name('courses.customer');


    Route::get('/chapters', [DashCoursesController::class, 'chapter'])->name('chapter');
    Route::get('/chapters/{id}', [DashCoursesController::class, 'chapterdetails'])->name('chapterdetails');

    Route::delete('/chapters/{id}', [DashCoursesController::class, 'destroy'])->name('chapters.destroy');


    Route::patch('/chapters/{id}/toggle-status', [DashCoursesController::class, 'toggleStatus'])->name('chapters.toggleStatus');



    




});


