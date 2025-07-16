<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;

class CourseCustomerController extends Controller
{
    /**
     * Get customers for a given course by course ID.
     *
     * @param  int  $courseId
     * @return JsonResponse
     */
    public function index(int $courseId): JsonResponse
    {
        // جلب الدورة بناءً على الـ ID
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // جلب العناصر المرتبطة بالدورة مع بيانات الكارت والمستخدم والمدفوعات
        $cartItems = CartItem::with(['cart.user', 'cart.payments'])
            ->where('course_id', $course->id)
            ->get();

        // تحضير بيانات العملاء
        $customers = $cartItems->map(function ($item) {
            $user = $item->cart->user;
            $payment = $item->cart->payments->last();  // آخر دفعة

            return [
                'id' => $item->id,
                'customer_name' => trim($user->first_name . ' ' . $user->last_name),
                'type' => 'Student',
                'country' => $payment?->country ?? 'N/A',
                'joined' => $payment?->created_at?->format('d M Y h:i A') ?? 'N/A',
                'total_amount' => $payment?->amount ?? 0,
                'last_order' => $payment?->id ?? null,
            ];
        });

        // لو القائمة فاضية نرجع رسالة مناسبة
        if ($customers->isEmpty()) {
            return response()->json(['message' => 'No customers found for this course'], 404);
        }

        return response()->json($customers);
    }
}
