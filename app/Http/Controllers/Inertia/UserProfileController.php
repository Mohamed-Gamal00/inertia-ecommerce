<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Requests\profile\CreateNewAddressRequest;
use App\Http\Requests\profile\UpdateNewAddressRequest;
use App\Http\Requests\profile\UserRequest;
use App\Models\City;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\User_verfication;
use App\Services\SMSGateways\moraSms;
use App\Services\VerificationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    protected $sms_service;
    protected $moraSms;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
    }

    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Profile/Index', compact('user'));
    }

    public function userWishList()
    {
        $user = Auth::user();
        $products = $user->wishlistProducts()->paginate(9);
        return Inertia::render('Profile/Wishlist', compact('products'));
    }

    public function userInfo()
    {
        $user = Auth::user();
        return Inertia::render('Profile/UserInfo', compact('user'));
    }

    public function updateUserInfo(UserRequest $request)
    {
        $user = Auth::user();
        $phoneChanged = $user->phone_number != $request->phone_number;

        if ($phoneChanged) {
            $verificationData = $this->sms_service->setVerificationCode($user->id);
            $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
            $this->moraSms->send_sms($user->phone_number, $message);

            session(['phone_number' => $request->phone_number]);
            return back()->with('success_update', 'تم ارسال كود التحقق الي رقمك.');
        }

        $user->update($request->all());
        return back()->with('info', 'تم تغيير البيانات بنجاح');
    }

    public function verify_to_update(Request $request)
    {
        $request->validate(['code' => 'required']);
        $user = Auth::user();
        $userVerification = User_verfication::where('user_id', $user->id)->first();

        if (!$userVerification) {
            return back()->with('error', 'لم يتم العثور على رمز التحقق.');
        }

        if (now()->greaterThan($userVerification->verification_code_expires_at)) {
            return back()->with('error', 'انتهت صلاحية رمز التحقق.');
        }

        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $request->code);
        if ($isValidCode) {
            $user->update(['phone_number' => session('phone_number')]);
            session()->forget('phone_number');
            return back()->with('info', 'تم تغيير البيانات بنجاح.');
        }

        return back()->with('error', 'الرمز غير صالح، أعد الإرسال.');
    }

    public function resendVerifyCodeToupdate()
    {
        $user = Auth::user();
        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
        $this->moraSms->send_sms($user->phone_number, $message);
        return back()->with('info', 'تم إرسال كود تحقق جديد.');
    }

    public function userAddresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->get();
        return Inertia::render('Profile/Addresses/Index', compact('addresses'));
    }

    public function userAddressesCreate()
    {
        $user = Auth::user();
        $countryId = $user->addresses()->where('main_address', 1)->value('country_id');
        $cities = City::where('country_id', $countryId)->where('status', 'used')->get();
        return Inertia::render('Profile/Addresses/Create', compact('cities'));
    }

    public function userAddressesStore(CreateNewAddressRequest $request)
    {
        UserAddress::create($request->all());
        return to_route('user.addresses')->with('success', 'تم اضافة العنوان');
    }

    public function userAddressesEdit($addressId)
    {
        $address = UserAddress::findOrFail($addressId);
        $cities = City::where('country_id', $address->country_id)->where('status', 'used')->get();
        return Inertia::render('Profile/Addresses/Edit', compact('address', 'cities'));
    }

    public function userAddressesUpdate(UpdateNewAddressRequest $request, $addressId)
    {
        $address = UserAddress::findOrFail($addressId);
        $address->update($request->all());
        return to_route('user.addresses')->with('success', 'تم تحديث العنوان');
    }

    public function userAddressesDestroy($addressId)
    {
        UserAddress::findOrFail($addressId)->delete();
        return to_route('user.addresses')->with('danger', 'تم مسح العنوان');
    }

    public function setMainAddress($addressId)
    {
        $user = Auth::user();
        $user->addresses()->update(['main_address' => 0]);
        $user->addresses()->where('id', $addressId)->update(['main_address' => 1]);
        return back()->with('success', 'تم تحديث العنوان الرئيسي بنجاح');
    }

    public function changePasswordView()
    {
        return Inertia::render('Profile/ChangePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['new_password' => 'required|confirmed|min:6']);
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->new_password)]);
        return to_route('user.info')->with('info', 'تم تغيير الرقم السري بنجاح');
    }
}
