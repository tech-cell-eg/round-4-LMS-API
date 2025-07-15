<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Commission;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'cart_items' => 'required|array', // IDs للكورسات
        ]);

      
        $payment = Payment::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'status' => 'success', 
        ]);

       
        foreach ($request->cart_items as $courseId) {
            $course = Course::findOrFail($courseId);

            $commissionAmount = $course->price * 0.1; // 10% عمولة مؤقتًا

            Commission::create([
                'instructor_id' => $course->instructor_id,
                'course_id'     => $course->id,
                'payment_id'    => $payment->id,
                'amount'        => $commissionAmount,
                'status'        => 'pending',
            ]);
        }

        
        return response()->json([
            'message' => 'Payment processed and commissions added successfully',
            'payment_id' => $payment->id,
        ]);
    }
}
