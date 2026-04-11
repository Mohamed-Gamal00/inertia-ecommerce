<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorNotificationController extends Controller
{
    public function read(Request $request, string $id)
    {
        $vendor = Auth::guard('vendor')->user();
        $notification = $vendor->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        $to = $request->input('redirect');
        if ($to && str_starts_with($to, '/') && ! str_starts_with($to, '//')) {
            return redirect($to);
        }

        return back();
    }

    public function markAllRead()
    {
        Auth::guard('vendor')->user()->unreadNotifications->markAsRead();

        return back();
    }
}
