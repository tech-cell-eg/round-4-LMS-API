<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
  public function index()
{
    $instructorId = auth()->id();

    // الحسابات
    $totalCommission = Commission::where('instructor_id', $instructorId)->sum('amount');
    $totalReceived = Commission::where('instructor_id', $instructorId)
        ->where('status', 'received')
        ->sum('amount');
    $totalPending = Commission::where('instructor_id', $instructorId)
        ->where('status', 'pending')
        ->sum('amount');

 
    $commissions = Commission::with(['payment.cart.user'])
        ->where('instructor_id', $instructorId)
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->through(function ($commission) {
            return [
                'order_id' => $commission->payment_id,
                'customer' => $commission->payment->cart->user->first_name . ' ' . $commission->payment->cart->user->last_name,
                'type' => $commission->payment->payment_method,
                'date' => $commission->created_at->format('Y-m-d'),
                'status' => $commission->status,
                'commission' => $commission->amount,
            ];
        });

    return response()->json([
        'totals' => [
            'total_commission' => $totalCommission,
            'total_received_commission' => $totalReceived,
            'total_pending_commission' => $totalPending,
        ],
        'commissions' => $commissions
    ]);
}

}
