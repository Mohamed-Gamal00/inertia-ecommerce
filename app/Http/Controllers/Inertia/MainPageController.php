<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SendNewsToUser;
use App\Models\User;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MainPageController extends Controller
{
    public function index(CartRepository $cart)
    {
        return view('front.index', \compact('cart'));
    }

    public function addEmailForNews(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'subscription_email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('send_news_to_users', 'subscription_email')->ignore(null, 'subscription_email')

            ],
        ]);

        SendNewsToUser::create([
            'subscription_email' => $request->subscription_email
        ]);

        return redirect()->back()->with('success', 'تم الاشتراك في النشرة البريدية بنجاح');
    }

    public function updateDefaultCurrency(Request $request)
    {
        $request->validate([
            'default_currency' => 'required|string|max:255',
        ]);


        // Update the default_currency column in the users table
        $request->session()->put('currency_id', $request->input('currency_id'));


        return response()->json(['success' => true, 'message' => 'تم تحديث العملة الافتراضية بنجاح.']);
    }
}
