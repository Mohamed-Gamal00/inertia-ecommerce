<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $setting    = Setting::first();
        $secret_key = $setting?->secret_key;

        if (!$secret_key) {
            return view('dashboard.payments.payments', [
                'payments' => new LengthAwarePaginator([], 0, 15),
                'error'    => 'لم يتم إعداد مفتاح بوابة الدفع. يرجى إضافته في الإعدادات.',
            ]);
        }

        $token = base64_encode($secret_key . ':');

        $response = Http::baseUrl('https://api.moyasar.com/v1')
            ->withHeaders(['Authorization' => "Basic {$token}"])
            ->get('payments', ['per_page' => 50]);

        if ($response->failed()) {
            return view('dashboard.payments.payments', [
                'payments' => new LengthAwarePaginator([], 0, 15),
                'error'    => 'فشل الاتصال ببوابة الدفع: ' . ($response->json()['message'] ?? $response->status()),
            ]);
        }

        $data     = $response->json()['payments'] ?? [];
        $payments = $this->paginate($data, 15);

        return view('dashboard.payments.payments', compact('payments'));
    }

    private function paginate($items, $perPage = 15, $page = null)
    {
        $page    = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items   = Collection::make($items);
        $options = ['path' => request()->url()];

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }
}
