<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\SendNewsToUser;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $already = SendNewsToUser::where('subscription_email', $request->email)->exists();

        if ($already) {
            return response()->json(['message' => __('flash.newsletter_already_subscribed')], 409);
        }

        SendNewsToUser::create(['subscription_email' => $request->email]);

        return response()->json(['message' => __('flash.newsletter_subscribed_success')]);
    }
}
