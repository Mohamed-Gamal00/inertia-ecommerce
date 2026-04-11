<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\SettingRequest;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Repositories\Setting\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    use Helper;

    public $settingRepo;
    public function __construct(SettingRepository $repo)
    {
        $this->settingRepo = $repo;
    }
    public function index()
    {
        //Gate::authorize('settings.edit');

        $setting = Setting::first();
        $orderStatus = OrderStatus::all();
        $currentOrderStatus = OrderStatus::where('default_status', true)->first();
        return view('dashboard.front_settings.edit', compact('setting', 'orderStatus', 'currentOrderStatus'));
    }

    public function update(SettingRequest $request, $id)
    {
        $data     = $request->validated();
        $settings = $this->settingRepo->getById($id);

        // Favicon
        $newImage = $this->uploadedImage(request(), 'image', 'website_image');
        if ($newImage) {
            if ($settings->image) Storage::disk('public')->delete($settings->image);
            $data['image'] = $newImage;
        }

        // Logo
        $newLogo = $this->uploadedLogo(request(), 'logo', 'website_image');
        if ($newLogo) {
            if ($settings->logo) Storage::disk('public')->delete($settings->logo);
            $data['logo'] = $newLogo;
        }

        // OG image
        if ($request->hasFile('og_image')) {
            if ($settings->og_image) Storage::disk('public')->delete($settings->og_image);
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        } else {
            unset($data['og_image']);
        }

        // Twitter image
        if ($request->hasFile('twitter_image')) {
            if ($settings->twitter_image) Storage::disk('public')->delete($settings->twitter_image);
            $data['twitter_image'] = $request->file('twitter_image')->store('seo', 'public');
        } else {
            unset($data['twitter_image']);
        }

        $this->settingRepo->update($data, $id);

        // Clear cached settings so changes reflect immediately
        cache()->forget('site_settings');

        return back()->with('success', __('messages.SETTING_UPDATED'));
    }
}
