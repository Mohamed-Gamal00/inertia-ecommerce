<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentTransaction::with('order')
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search (order number or moyasar ID)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('moyasar_payment_id', 'LIKE', "%{$request->search}%")
                  ->orWhereHas('order', fn($o) => $o->where('number', 'LIKE', "%{$request->search}%"));
            });
        }

        $transactions = $query->paginate(20)->withQueryString();

        $stats = [
            'total_paid'   => PaymentTransaction::where('status', 'paid')->sum('amount'),
            'paid_count'   => PaymentTransaction::where('status', 'paid')->count(),
            'failed_count' => PaymentTransaction::where('status', 'failed')->count(),
            'today_paid'   => PaymentTransaction::where('status', 'paid')->whereDate('created_at', today())->sum('amount'),
        ];

        return view('dashboard.payments.payments', compact('transactions', 'stats'));
    }

    public function show($id)
    {
        $transaction = PaymentTransaction::with('order.addresses', 'order.orderItems.product')
            ->findOrFail($id);

        return view('dashboard.payments.show', compact('transaction'));
    }
}
