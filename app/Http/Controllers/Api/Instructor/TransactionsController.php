<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Payment;

class TransactionsController extends Controller
{
    public function getTransactionsJson()
{
    $transactions = Payment::with('cart.user')
        ->latest()
        ->get()
        ->map(function ($payment) {
            return [
                'id' => $payment->id,
                'user_name' => optional($payment->cart->user)->first_name . ' ' . optional($payment->cart->user)->last_name,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'date' => $payment->created_at->format('Y-m-d H:i:s'),
            ];
        });

    $totalAmount = $transactions->sum('amount');
    $lastPaymentAmount = $transactions->first()['amount'] ?? 0;

    return ApiResponse::sendResponse([
        'total_paid' => $totalAmount,
        'last_payment' => $lastPaymentAmount,
        'transactions' => $transactions
    ], 'Transactions fetched successfully');
}



}
