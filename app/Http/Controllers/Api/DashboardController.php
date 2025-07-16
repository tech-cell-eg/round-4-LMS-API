<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $instructorId = auth()->id();

        // إجمالي العمولات
        $totalCommissions = Commission::where('instructor_id', $instructorId)->sum('amount');

        // العمولات المستلمة
        $receivedCommissions = Commission::where('instructor_id', $instructorId)
            ->where('status', 'received')
            ->sum('amount');

        // العمولات المعلقة
        $pendingCommissions = Commission::where('instructor_id', $instructorId)
            ->where('status', 'pending')
            ->sum('amount');

        // توزيع المبيعات خلال السنة
        $salesByMonth = Commission::where('instructor_id', $instructorId)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // التقييمات الخاصة بالكورسات بتاعة المدرب
        $courseIds = \App\Models\Course::where('instructor_id', $instructorId)->pluck('id');

        $reviews = Review::where('reviewable_type', \App\Models\Course::class)
            ->whereIn('reviewable_id', $courseIds)
            ->get();

        
        $reviewCounts = [
            '1_star' => $reviews->whereBetween('rating', [0.5, 1.4])->count(),
            '2_star' => $reviews->whereBetween('rating', [1.5, 2.4])->count(),
            '3_star' => $reviews->whereBetween('rating', [2.5, 3.4])->count(),
            '4_star' => $reviews->whereBetween('rating', [3.5, 4.4])->count(),
            '5_star' => $reviews->whereBetween('rating', [4.5, 5])->count(),
            'total'  => $reviews->count(),
        ];

        return response()->json([
            'total_commissions'     => $totalCommissions,
            'received_commissions'  => $receivedCommissions,
            'pending_commissions'   => $pendingCommissions,
            'sales_by_month'        => $salesByMonth,
            'reviews'               => $reviewCounts,
        ]);
    }
}
