<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Api\Instructor\InstructorChatController;
use App\Http\Controllers\Api\Instructor\InstructorNotificationController;
use App\Http\Controllers\Api\Instructor\InstructorReviewController;
use App\Http\Controllers\Api\Instructor\SyllabusResourcesController;
use App\Http\Controllers\Api\Instructor\SyllabusSeoController;
use App\Http\Controllers\Api\Student\CartController;
use App\Http\Controllers\Api\Student\CategoryController;
use App\Http\Controllers\Api\Student\ChatController;
use App\Http\Controllers\Api\Student\CourseController;
use App\Http\Controllers\Api\Student\InstructorController;
use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\ReviewController;
use App\Http\Controllers\Api\Student\SyllabusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Instructor\CouponController;
use App\Http\Controllers\Api\Instructor\CourseSettingController;
use App\Http\Controllers\CourseCustomerController;
use App\Http\Controllers\Api\Instructor\TransactionsController;

// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

// Instructor Routes
Route::group(['middleware' => ['auth:sanctum', 'is_instructor']], function () {
    Route::post('/courses', [InstructorCourseController::class, 'store']);
    Route::get('/test/courses/{slug}', [InstructorCourseController::class, 'show']); // up


    // coupons
    Route::get('coupons', [CouponController::class, 'index']);
    Route::post('coupons', [CouponController::class, 'store']);
    Route::get('coupons/{coupon}', [CouponController::class, 'show']);
    Route::match(['put', 'patch'], 'coupons/{coupon}', [CouponController::class, 'update']);
    Route::delete('coupons/{coupon}', [CouponController::class, 'destroy']);

    //transactions
    Route::get('/transactions', [TransactionsController::class, 'getTransactionsJson']);
    //course settings
    Route::post('/courses/{course}/settings', [CourseSettingController::class, 'store']);

    Route::get('/instructor/{id}/courses-dashboard', [InstructorCourseController::class, 'DashboardInstructorCourses']);
    Route::get('/instructors/{id}/reviews', [InstructorReviewController::class, 'index']);
    Route::get('/courses/{course}/customers', [CourseCustomerController::class, 'index']);

    // Syllabus Resources
    Route::post('/syllabus/{id}/resources', [SyllabusResourcesController::class, 'store']);
    Route::get('/syllabus/{id}/resources', [SyllabusResourcesController::class, 'show']);

    // Syllabus SEO
    Route::get('/syllabus/{id}/seo', [SyllabusSeoController::class, 'show']);
    Route::post('/syllabus/{id}/seo', [SyllabusSeoController::class, 'store']);

    // Notifications
    Route::get('/instructor/notifications', [InstructorNotificationController::class, 'index']);

    // Chat
    Route::get('/chats', [InstructorChatController::class, 'chats']);
    Route::get('/chats/{chatId}', [InstructorChatController::class, 'messages']);
    Route::post('/student/{studentUsername}/chat', [InstructorChatController::class, 'sendMessage']);

});


//Student Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Student Profile Routes
    Route::get('instructors/{instructorUsername}', [InstructorProfileController::class, 'show'])->name('instructor.show');
    Route::get('/my-courses', [ProfileController::class, 'myCourses']);
    Route::get('/my-instructors', [ProfileController::class, 'myInstructors']);
    Route::get('/my-reviews', [ProfileController::class, 'myReviews']);


    // Courses Routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
    Route::get('/courses/{id}', [CourseController::class, 'showCourseDetails']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/courses/{course}/instructor', [CourseController::class, 'showInstructorInfoRelatedToCourse']);


    // Cart routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{course_id}', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    Route::get('/cart/my-courses', [CartController::class, 'registeredCourses']);

    // Reviews on Courses
    Route::prefix('courses/{courseId}/reviews')->controller(ReviewController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/{reviewId}', 'show');
        Route::put('/{reviewId}', 'update');
        Route::delete('/{reviewId}', 'destroy');
    });

    // Instructors Routes
    Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
    Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
    Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);
    Route::get('/instructors/{instructor}/courses', [InstructorController::class, 'showInstructorCourses']);

    // Chat
    Route::get('/my-chats', [ChatController::class, 'myChats']);
    Route::get('/my-chats/{chatId}', [ChatController::class, 'GetMessages']);
    Route::post('/instructor/{instructorUsername}/chat', [ChatController::class, 'sendMessage']);

});

// Syllabus
Route::get('courses/{courseId}/syllabuses', [SyllabusController::class, 'index']);
// Reviews on Courses
Route::get('courses/{courseId}/reviews', [ReviewController::class, 'index']);
