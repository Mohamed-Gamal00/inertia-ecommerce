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

    // public function index()
    // {
    //     $user = Auth::user()->load('orders.orderItems');
    //     // return $user;
    //     return Inertia::render('Profile/Index', compact('user'));
    // }

    public function index()
    {
        $user = Auth::user();

        $user->load([
            'orders.orderItems',
            'addresses',
            'wishlistProducts' => function ($query) use ($user) {
                $query->with(['images', 'parent'])
                    ->withIsInWishlist($user);
            },
        ]);
        return Inertia::render('Profile/Index', compact('user'));
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
        return to_route('user.addresses')->with('success', __('flash.address_added'));
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
        return to_route('user.addresses')->with('success', __('flash.address_updated'));
    }

    public function userAddressesDestroy($addressId)
    {
        UserAddress::findOrFail($addressId)->delete();
        return to_route('user.addresses')->with('danger', __('flash.address_deleted'));
    }

    public function setMainAddress($addressId)
    {
        $user = Auth::user();
        $user->addresses()->update(['main_address' => 0]);
        $user->addresses()->where('id', $addressId)->update(['main_address' => 1]);
        return back()->with('success', __('flash.main_address_updated'));
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
        return to_route('user.info')->with('info', __('flash.password_changed'));
    }
}
