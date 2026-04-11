<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }

        $vendor = Auth::guard('vendor')->user();

        if ($vendor->status !== 'active') {
            Auth::guard('vendor')->logout();
            return redirect()->route('vendor.login')
                ->withErrors(['email' => 'حسابك قيد المراجعة أو موقوف. تواصل مع الإدارة.']);
        }

        return $next($request);
    }
}
