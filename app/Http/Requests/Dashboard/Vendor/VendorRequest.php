<?php

namespace App\Http\Requests\Dashboard\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $vendorId = $this->route('vendor') ? $this->route('vendor')->id : null;

        return [
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('companies', 'email')->ignore($vendorId)
            ],
            'password' => $vendorId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'store_slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('companies', 'store_slug')->ignore($vendorId)
            ],
            'banner_color' => 'nullable|string|max:7',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,pending,suspended',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_license' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'return_policy' => 'nullable|string|max:2000',
            'shipping_policy' => 'nullable|string|max:2000',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المتجر مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'store_slug.required' => 'رابط المتجر مطلوب',
            'store_slug.unique' => 'رابط المتجر مستخدم بالفعل',
            'store_slug.regex' => 'رابط المتجر يجب أن يحتوي على أحرف صغيرة وأرقام وشرطات فقط',
            'commission_rate.required' => 'نسبة العمولة مطلوبة',
            'commission_rate.numeric' => 'نسبة العمولة يجب أن تكون رقم',
            'commission_rate.min' => 'نسبة العمولة يجب أن تكون 0 أو أكثر',
            'commission_rate.max' => 'نسبة العمولة يجب أن تكون 100 أو أقل',
            'status.required' => 'حالة البائع مطلوبة',
            'image.image' => 'صورة الملف الشخصي يجب أن تكون صورة',
            'cover_image.image' => 'صورة الغلاف يجب أن تكون صورة',
        ];
    }
}
