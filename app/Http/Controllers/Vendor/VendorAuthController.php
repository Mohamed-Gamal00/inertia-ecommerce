<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorAuthController extends Controller
{
    public function loginView()
    {
        return view('vendor.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendor = Company::where('email', $request->email)->where('is_vendor', true)->first();

        if (! $vendor || ! Hash::check($request->password, $vendor->password)) {
            return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة.']);
        }

        if ($vendor->status !== 'active') {
            return back()->withErrors(['email' => 'حسابك قيد المراجعة أو موقوف.']);
        }

        Auth::guard('vendor')->login($vendor);
        $request->session()->regenerate();

        return redirect()->route('vendor.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }

    public function registerView()
    {
        return view('vendor.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'nullable|string',
        ]);

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_vendor' => true,
            'status' => 'pending', // needs admin approval
        ]);

        return redirect()->route('vendor.login')
            ->with('success', 'تم تسجيل طلبك بنجاح. سيتم مراجعته من قِبل الإدارة.');
    }
}
