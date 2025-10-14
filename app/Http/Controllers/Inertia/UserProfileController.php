<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Requests\profile\CreateNewAddressRequest;
use App\Http\Requests\profile\UpdateNewAddressRequest;
use App\Http\Requests\profile\UserRequest;
use App\Models\Admin;
use App\Models\City;
use App\Models\Product;
use App\Models\User;
use App\Models\User_verfication;
use App\Models\UserAddress;
use App\Services\SMSGateways\moraSms;
use App\Services\VerificationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public $sms_service;
    public $moraSms;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
    }

    public function index()
    {
        return view('front.profile.index');
    }

    public function userWishList()
    {
        $user = Auth::guard('web')->user();
        $products = $user->wishlistProducts()->paginate(9);
        return view('front.profile.user_wishlist', \compact('products'));
    }

    public function userInfo()
    {
        $user = Auth::guard('web')->user();
        return view('front.profile.user_info', \compact('user'));
    }

    public function updateUserInfo(UserRequest $request)
    {
        $user = Auth::guard('web')->user();

        $phoneChanged = $user->phone_number != $request->phone_number;

        if ($phoneChanged) {

            // Generate the verification code and SMS
            $verificationData = $this->sms_service->setVerificationCode($user->id);
            $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
            $smsSent = $this->moraSms->send_sms($user->phone_number, $message);

//            $smsSent = true;

            if ($smsSent) {
                // Authenticate the user
                session(['phone_number' => $request->phone_number]);
                return redirect()->back()->with('success_update', " . تم ارسال كود التحقق الي رقمك.",);
            } else {
                return response()->json([
                    'message' => 'Failed to send verification SMS. Please try again.',
                ], 500);
            }

        }

        $user->update($request->all());
        return to_route('user.info')->with('info', 'تم تغيير البيانات بنجاح');

    }

    public function verify_to_update(Request $request)
    {

        $verificationData = $request->validate([
            'code' => 'required',
        ]);

//        dd($request->all());

        $user = Auth::guard('web')->user();
        if (!$user) {
            return response()->json(['message' => 'User ID not found in session'], 404);
        }

        $user = User::find($user->id);
//        dd($user);
        if (!$user) {
            return redirect()->back()->with('success_update', 'User not found.');
        }
        /*check expired code*/
        $user_verificationCode = User_verfication::where('user_id', $user->id)->first();
        if ($user_verificationCode->verification_code_expires_at && now()->greaterThan($user_verificationCode->verification_code_expires_at)) {
            return redirect()->back()->with('success_update', 'انتهت صلاحية رمز التحقق. يرجى طلب واحد جديدة.');
        }

        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $verificationData['code']);
        if ($isValidCode) {
            $user->update([
                'phone_number' => session('phone_number')
            ]);
            session()->forget(['phone_number']);

            return redirect()->back()->with('info', 'تم تغيير البيانات بنجاح.');
//            return to_route('user.info')->with('info', 'تم تغيير البيانات بنجاح');
        } else {
            // Invalid code, resend the verification code
            return redirect()->back()->with('success_update', 'الرمز غير صالح، أعد إرسال رمز التحقق.');
        }
    }

    public function resendVerifyCodeToupdate(Request $request)
    {
        $user = Auth::guard('web')->user();
        $user = User::where('id', $user->id)->first();
        if (!$user) {
            return 'user id not found';
        }

        return $this->handleTelephoneVerification($user);
    }


    public function handleTelephoneVerification($user)
    {
        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
//        $smsSent = $this->moraSms->send_sms($user->telephone, $message);
        $smsSent = true;

        if ($smsSent) {
            return true;
        } else {
            return false;
        }
    }

    public function userAddresses()
    {
        $user = Auth::guard('web')->user();
        // $returnProducts = User::with('returnProducts', 'orders.products')->where('id', $user->id)->first();
        return view('front.profile.user_addresses', compact('user'));
    }

    public function setMainAddress($addressId)
    {
        $user = Auth::guard('web')->user();

        // Set all addresses main_address to false
        $user->addresses()->update(['main_address' => 0]);

        // Set the selected address main_address to true
        $user->addresses()->where('id', $addressId)->update(['main_address' => 1]);

        return redirect()->route('user.addresses')->with('success', 'Main address updated successfully.');
    }

    public function userAddressesCreate()
    {
        $user = Auth::guard('web')->user();
        $countryId = UserAddress::select('country_id')->where('user_id', $user->id)
            ->where('main_address', 1)
            ->first();
        // dd($countryId);
        $cities = City::where('country_id', $countryId->country_id)
            ->where('status', 'used')
            ->get();

        return view('front.profile.create_edit_addresses.create', \compact('user', 'cities', 'countryId'));
    }

    public function userAddressesStore(CreateNewAddressRequest $request)
    {

        UserAddress::create($request->all());
        return to_route('user.addresses')->with('success', 'تم اضافة العنوان');
    }

    public function userAddressesEdit($addressId)
    {
        $user = Auth::guard('web')->user();
        $address = UserAddress::findOrFail($addressId);


        $cities = City::where('country_id', $address->country_id)
            ->where('status', 'used')
            ->get();

        return view('front.profile.create_edit_addresses.edit', \compact('user', 'address', 'cities'));
    }

    public function userAddressesUpdate(UpdateNewAddressRequest $request, $addressId)
    {
        $address = UserAddress::findOrFail($addressId);
        $address->update($request->all());
        return to_route('user.addresses')->with('success', 'تم تحديث العنوان');
    }

    public function userAddressesDestroy(Request $request, $addressId)
    {
        $address = UserAddress::findOrFail($addressId);
        $address->delete();
        return to_route('user.addresses')->with('danger', 'تم مسح العنوان');
    }

    public function changePasswordView()
    {
        return view('front.profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed|min:6'
        ]);
        $user = Auth::guard('web')->user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        return to_route('user.info')->with('info', 'تم تغيير الرقم السري بنجاح');
    }
}
