<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Instructor\CouponController;
use App\Http\Controllers\Api\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Api\Instructor\CourseDetailsController;
use App\Http\Controllers\Api\Instructor\CourseSettingController;
use App\Http\Controllers\Api\Instructor\InstructorChatController;
use App\Http\Controllers\Api\Instructor\InstructorCourseReviewsController;
use App\Http\Controllers\Api\Instructor\InstructorReviewController;
use App\Http\Controllers\Api\Instructor\TransactionsController;
use App\Http\Controllers\Api\PaymentController;

use App\Http\Controllers\Api\Instructor\SyllabusResourcesController;
use App\Http\Controllers\Api\Instructor\SyllabusSeoController;
use App\Http\Controllers\Api\Instructor\CommissionController;
use App\Http\Controllers\Api\Student\CartController;
use App\Http\Controllers\Api\Student\CategoryController;
use App\Http\Controllers\Api\Student\ChatController;
use App\Http\Controllers\Api\Student\CourseController;
use App\Http\Controllers\Api\Student\InstructorController;
use App\Http\Controllers\Api\Student\InstructorProfileController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\ReviewController;
use App\Http\Controllers\Api\Student\StudentProfileController;
use App\Http\Controllers\Api\Student\SyllabusController;
use App\Http\Controllers\Api\Instructor\CourseCustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes (auth:sanctum + is_instructor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'is_instructor'])->group(function () {
    // Courses
    Route::post('/courses', [InstructorCourseController::class, 'store']);
    Route::get('/test/courses/{slug}', [InstructorCourseController::class, 'show']);
    Route::get('/instructor/{id}/courses-dashboard', [InstructorCourseController::class, 'DashboardInstructorCourses']);
    Route::post('/courses/{course}/settings', [CourseSettingController::class, 'store']);

    // Dashboard
    Route::get('/instructor/dashboard', [DashboardController::class, 'index']);

    // Commissions
    Route::get('/instructor/commissions', [CommissionController::class, 'index']);

    // Coupons
    Route::get('coupons', [CouponController::class, 'index']);
    Route::post('coupons', [CouponController::class, 'store']);
    Route::get('coupons/{coupon}', [CouponController::class, 'show']);
    Route::match(['put', 'patch'], 'coupons/{coupon}', [CouponController::class, 'update']);
    Route::delete('coupons/{coupon}', [CouponController::class, 'destroy']);

    // Transactions
    Route::get('/transactions', [TransactionsController::class, 'getTransactionsJson']);

    // Course Reviews
    Route::get('/instructor/course-reviews', [InstructorCourseReviewsController::class, 'index']);
    Route::get('/instructor/course-reviews/summary', [InstructorCourseReviewsController::class, 'ratingSummary']);

    // Instructor Reviews
    Route::get('/instructors/{id}/reviews', [InstructorReviewController::class, 'index']);
    Route::get('/courses/{course}/customers', [CourseCustomerController::class, 'index']);

    // Syllabus Resources
    Route::post('/syllabus/{id}/resources', [SyllabusResourcesController::class, 'store']);
    Route::get('/syllabus/{id}/resources', [SyllabusResourcesController::class, 'show']);

    // Syllabus SEO
    Route::get('/syllabus/{id}/seo', [SyllabusSeoController::class, 'show']);
    Route::post('/syllabus/{id}/seo', [SyllabusSeoController::class, 'store']);

    // Course Customers
    Route::get('/courses/{course}/customers', [CourseCustomerController::class, 'index']);

    // Chapters
    Route::get('/chapters', [InstructorCourseController::class, 'chapter']);
    Route::get('/chapters/{id}', [InstructorCourseController::class, 'chapterdetails']);
    Route::delete('/chapters/{id}', [InstructorCourseController::class, 'destroy']);
    Route::put('/chapters/{id}/toggle-status', [InstructorCourseController::class, 'toggleStatus']);

    // Create New Course
    Route::put('/courses/{id}/save-draft', [CourseDetailsController::class, 'saveAsDraft']);
    Route::put('/courses/{id}/publish', [CourseDetailsController::class, 'publish']);
    Route::patch('/courses/{id}', [CourseDetailsController::class, 'update']);

    // Chat
    Route::get('/chats', [InstructorChatController::class, 'chats']);
    Route::get('/chats/{chatId}', [InstructorChatController::class, 'messages']);
    Route::post('/student/{studentUsername}/chat', [InstructorChatController::class, 'sendMessage']);

});

/*
|--------------------------------------------------------------------------
| Student & Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    // Instructor Profile
    Route::get('instructors/{instructorUsername}', [InstructorProfileController::class, 'show'])->name('instructor.show');

    // Student Profile
    Route::get('/my-courses', [ProfileController::class, 'myCourses']);
    Route::get('/my-instructors', [ProfileController::class, 'myInstructors']);
    Route::get('/my-reviews', [ProfileController::class, 'myReviews']);


    // Courses
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/category/{category}', [CourseController::class, 'filterByCategory']);
    Route::get('/courses/{id}', [CourseController::class, 'showCourseDetails']);
    Route::get('/courses/{course}/instructor', [CourseController::class, 'showInstructorInfoRelatedToCourse']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Payment
    Route::post('/payment', [PaymentController::class, 'store']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{course_id}', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    Route::get('/cart/my-courses', [CartController::class, 'registeredCourses']);

    // Course Reviews
    Route::prefix('courses/{courseId}/reviews')->controller(ReviewController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/{reviewId}', 'show');
        Route::put('/{reviewId}', 'update');
        Route::delete('/{reviewId}', 'destroy');
    });

    // Instructor Reviews
    Route::post('/instructors/{instructor}/review', [InstructorController::class, 'store']);
    Route::get('/instructors/{instructor}/reviews', [InstructorController::class, 'index']);
    Route::get('/top-instructors', [InstructorController::class, 'topInstructors']);
    Route::get('/instructors/{instructor}/courses', [InstructorController::class, 'showInstructorCourses']);

    Route::get('/student/profile', [StudentProfileController::class, 'show']);
    Route::put('/student/profile', [StudentProfileController::class, 'update']);

    // Chat
    Route::get('/my-chats', [ChatController::class, 'myChats']);
    Route::get('/my-chats/{chatId}', [ChatController::class, 'GetMessages']);
    Route::post('/instructor/{instructorUsername}/chat', [ChatController::class, 'sendMessage']);

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('courses/{courseId}/syllabuses', [SyllabusController::class, 'index']);
Route::get('courses/{courseId}/reviews', [ReviewController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index']);
