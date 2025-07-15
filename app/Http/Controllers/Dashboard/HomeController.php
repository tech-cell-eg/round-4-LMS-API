<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('instructor.dashboard', [
            'summary'         => $this->getSalesSummary(),
            'courses'         => $this->getInstructorCourses(),
            'salesTimeline'   => $this->getSalesTimeline(),
            'detailedRatings' => $this->getDetailedRatingSummary(),
            'starCounts' => collect($this->getDetailedRatingSummary()['details'])
            ->pluck('count', 'rating'),
            'totalReviews' => $this->getDetailedRatingSummary()['total'],

        ]);
    }

    public function getSalesSummary()
    {
        $commissionRate = 20;
        $totalSales = Payment::sum('amount');
        $totalCommission = Payment::sum(DB::raw("amount * $commissionRate / 100"));
        $receivedCommission = Payment::where('state', 'received')->sum(DB::raw("amount * $commissionRate / 100"));
        $pendingCommission = Payment::where('state', 'pending')->sum(DB::raw("amount * $commissionRate / 100"));

        return [
            'totalSales'         => round($totalSales, 2),
            'totalCommission'    => round($totalCommission, 2),
            'receivedCommission' => round($receivedCommission, 2),
            'pendingCommission'  => round($pendingCommission, 2),
        ];
    }

    public function getInstructorCourses()
    {
        $instructor = auth()->guard('instructor')->user();

        $courses = Course::with(['syllabuses.lessons', 'enrollments', 'reviews'])
            ->where('instructor_id', $instructor->id)
            ->get();

        return $courses->map(function ($course) {
            $lessons = $course->syllabuses->flatMap->lessons;
            return [
                'id'             => $course->id,
                'title'          => $course->title,
                'image'          => $course->image,
                'level'          => $course->levels,
                'price'          => $course->price,
                'lectures'       => $lessons->count(),
                'duration'       => round($lessons->sum('duration') / 60, 2),
                'orders_count'   => $course->enrollments->count(),
                'rating'         => round($course->reviews->avg('rating'), 1),
                'rating_count'   => $course->reviews->count(),
                'added_to_shelf' => CartItem::where('course_id', $course->id)->count(),
                'certificates'   => 'N/A',
                'reviews'        => $course->reviews,
            ];
        });
    }

    public function getSalesTimeline()
    {
        $instructor = auth()->guard('instructor')->user();
        $courseIds = $instructor->courses->pluck('id')->toArray();

        $cartIds = CartItem::whereIn('course_id', $courseIds)->pluck('cart_id');

        $sales = Payment::whereIn('cart_id', $cartIds)
            ->where('state', 'complete')
            ->selectRaw("DATE(created_at) as date, SUM(amount) as total")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $sales->map(function ($item) {
            return [
                'date'  => $item->date,
                'total' => round($item->total, 2),
            ];
        });
    }

    public function getDetailedRatingSummary()
{
    $instructor = auth()->guard('instructor')->user();
    $courses = Course::where('instructor_id', $instructor->id)->pluck('id');

    $starCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    $totalReviews = Review::where('reviewable_type', Course::class)
                          ->whereIn('reviewable_id', $courses)
                          ->count();

    $ratings = Review::where('reviewable_type', Course::class)
                     ->whereIn('reviewable_id', $courses)
                     ->select(DB::raw('ROUND(rating) as rounded_rating'), DB::raw('count(*) as total'))
                     ->groupBy('rounded_rating')
                     ->pluck('total', 'rounded_rating')
                     ->toArray();

    foreach ($ratings as $rating => $count) {
        $starCounts[$rating] = $count;
    }

    $details = [];
    foreach ($starCounts as $star => $count) {
        $details[] = [
            'label'  => "$star star reviews",
            'count'  => $count,
            'rating' => number_format($star, 1),
        ];
    }

    return [
        'total'   => $totalReviews,
        'details' => $details,
    ];
}

}
