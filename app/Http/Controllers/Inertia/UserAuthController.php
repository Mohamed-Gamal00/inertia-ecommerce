<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest ;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\User_verfication;
use App\Models\UserAddress;
use App\Services\SMSGateways\moraSms;
use App\Services\VerificationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserAuthController extends Controller
{
    public $sms_service;
    public $moraSms;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
    }

    /* ================== AUTH VIEWS ================== */

    public function loginView()
    {
        return Inertia::render('Auth/Login');
    }

    public function registerView()
    {
        $countries = Country::where('status', 'used')->get();
        $countriesId =  Country::where('status', 'used')->pluck('id')->toArray();
        $cities = City::whereIn('country_id', $countriesId)->where('status', 'used')->get();

        // dd($cities);

        return Inertia::render('Auth/Register', [
            'countries' => $countries,
            'cities' => $cities,
        ]);
    }

    public function forgotPasswordView()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function resetPasswordView()
    {
        return Inertia::render('Auth/ResetPassword');
    }

    /* ================== AUTH ACTIONS ================== */

    // ✅ Handle Register
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'family_name' => $data['family_name'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'address' => $data['address'],
            ]);

            UserAddress::create([
                'address_title' => 'العنوان الأساسي',
                'first_name' => $user->first_name,
                'family_name' => $user->family_name,
                'phone_number' => $user->phone_number,
                'user_id' => $user->id,
                'address' => $data['address'],
                'country_id' => 178,
                'city_id' => $data['city_id'],
                'main_address' => true,
            ]);

            Auth::guard('web')->login($user);
        });

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // dd($credentials);
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        $user_id = session('user_id');
        if (!$user_id) {
            return back()->with('error', 'انتهت الجلسة، حاول مرة أخرى.');
        }

        $user = User::find($user_id);
        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $request->code);

        if ($isValidCode) {
            $user->verificationCode()->update(['is_verified' => 1]);
            Auth::login($user);
            session()->forget(['user_id', 'verification_code']);

            return redirect()->route('home')->with('success', 'تم تفعيل حسابك بنجاح');
        }

        return back()->with('error', 'الرمز غير صالح.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['phone_number' => 'required|exists:users,phone_number']);
        $user = User::where('phone_number', $request->phone_number)->first();

        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
        $this->moraSms->send_sms($user->phone_number, $message);

        session(['user_id' => $user->id, 'verification_code' => $verificationData->code]);

        return back()->with('success', 'تم إرسال كود التحقق لإعادة تعيين كلمة المرور.');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:8']);
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('user.forgotPasswordView')->with('error', 'انتهت الجلسة، حاول مرة أخرى.');
        }

        $user->update(['password' => Hash::make($request->password)]);
        session()->forget(['user_id', 'verification_code']);

        return redirect()->route('login')->with('success', 'تم تحديث كلمة المرور بنجاح.');
    }
}
