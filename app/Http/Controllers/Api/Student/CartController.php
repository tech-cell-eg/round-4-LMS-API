<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function add(Request $request)
    {
    $request->validate([
        'course_id' => 'required|exists:courses,id',
    ]);
    $user = $request->user();
    $cart = $user->cart ?? $user->cart()->create();
    $exists = $cart->items()->where('course_id', $request->course_id)->exists();
    if ($exists) {
        return response()->json(['message' => 'Course already in cart'], 200);
    }
    $cart->items()->create([
        'course_id' => $request->course_id,
    ]);
    return response()->json(['message' => 'Course added to cart'], 201);
    }


         public function index(Request $request)
    {
         $cartItems = $request->user()->cart->items()
        ->with(['course.instructor', 'course.reviews', 'course.syllabuses.lessons'])
        ->get();

        $formattedCart = [];
        foreach ($cartItems as $item) {
            $course = $item->course;
            $instructor = $course->instructor;
            $instructorName = $instructor ? $instructor->first_name . ' ' . $instructor->last_name : 'Unknown';
            $ratingCount = $course->reviews->count();
            $averageRating = $ratingCount > 0 ? round($course->reviews->avg('rating'), 1) : 0;
            $lessons = $course->syllabuses->flatMap->lessons;
            $totalDuration = $lessons->sum('duration'); // minutes
            $lectureCount = $lessons->count();
            $level = match($course->levels) {
                0 => 'Beginner',
                1 => 'Intermediate',
                2 => 'Advanced',
                default => 'All levels',
            };

            $formattedCart[] = [
                'id'              => $item->id,
                'course_id'       => $course->id,
                'title'           => $course->title,
                'price'           => $course->price,
                'discount'        => $course->discount,
                'tax'             => $course->tax,
                'image'           => $course->image,
                'instructor'      => $instructorName,
                'average_rating'  => $averageRating,
                'rating_count'    => $ratingCount,
                'total_hours'     => round($totalDuration / 60, 2),
                'lectures'        => $lectureCount,
                'level'           => $level,
                'overview'        => $course->overview,
            ];
        }

        return response()->json([
            'cart' => $formattedCart
        ]);
        }



    public function remove(Request $request, $course_id)
    {
        $cart = $request->user()->cart;
        $deleted = $cart->items()->where('course_id', $course_id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Course removed from cart']);
        }
        return response()->json(['message' => 'Course not found in cart'], 404);
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->cart->items;
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }
        foreach ($cartItems as $item) {
            $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                ->where('course_id', $item->course_id)
                ->exists();
            if (!$alreadyEnrolled) {
                Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $item->course_id,
                ]);
            }
        }
        $user->cart->items()->delete();
        return response()->json(['message' => 'Enrolled in all courses successfully']);

    }

    public function registeredCourses(Request $request)
    {
    $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with([
                'course.reviews','course.syllabuses.lessons','course.instructor'
            ])->get();

        $courses = $enrollments->pluck('course')->filter();
        $detailedCourses = [];
        $totalCost = 0;

        foreach ($courses as $course) {
            if (!$course) continue;

            $price = $course->price ?? 0;
            $discount = $course->discount ?? 0;
            $priceAfterDiscount = $price - $discount;
            $tax = $priceAfterDiscount * (($course->tax ?? 0) / 100);
            $finalPrice = $priceAfterDiscount + $tax;

            $instructor = $course->instructor;
            $instructorName = $instructor ? $instructor->first_name . ' ' . $instructor->last_name : 'Unknown';

            $ratingCount = $course->reviews->count();
            $averageRating = $ratingCount > 0 ? round($course->reviews->avg('rating'), 1) : 0;

            $lessons = $course->syllabuses->flatMap->lessons;
            $totalDuration = $lessons->sum('duration');
            $lectureCount = $lessons->count();

            $detailedCourses[] = [
                'title'             => $course->title,
                'price'             => $price,
                'discount'          => $discount,
                'tax'               => round($tax, 2),
                'final_price'       => round($finalPrice, 2),
                'instructor'        => $instructorName,
                'average_rating'    => $averageRating,
                'rating_count'      => $ratingCount,
                'total_hours'       => round($totalDuration / 60, 2),
                'lectures'          => $lectureCount,
                'level'             => $course->levels,
                'image'             => $course->image,
                'overview'          => $course->overview,
            ];

            $totalCost += $finalPrice;
        }
        return response()->json([
            'courses'     => $detailedCourses,
            'total_cost'  => round($totalCost, 2),
        ]);
    }

}
