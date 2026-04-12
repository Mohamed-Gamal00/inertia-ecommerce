<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VendorProfileController extends Controller
{
    protected function vendor()
    {
        return Auth::guard('vendor')->user();
    }

    /**
     * Show vendor profile edit form
     */
    public function edit()
    {
        $vendor = $this->vendor();
        return view('vendor.profile.edit', compact('vendor'));
    }

    /**
     * Update vendor profile
     */
    public function update(Request $request)
    {
        $vendor = $this->vendor();

        $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $vendor->id,
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'store_slug' => 'required|string|max:255|unique:companies,store_slug,' . $vendor->id,
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
            'banner_color' => 'nullable|string|max:7',
            'return_policy' => 'nullable|string',
            'shipping_policy' => 'nullable|string',
            'bank_account' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.instagram' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.facebook' => 'nullable|url',
            'social_links.whatsapp' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'cover_image']);

        // Handle logo upload
        if ($request->hasFile('image')) {
            if ($vendor->image) {
                Storage::disk('public')->delete($vendor->image);
            }
            $data['image'] = $request->file('image')->store('companies', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($vendor->cover_image) {
                Storage::disk('public')->delete($vendor->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('companies/covers', 'public');
        }

        // Ensure store_slug is unique and URL-friendly
        $data['store_slug'] = Str::slug($request->store_slug);

        $vendor->update($data);

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $vendor = $this->vendor();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $vendor->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $vendor->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
}
