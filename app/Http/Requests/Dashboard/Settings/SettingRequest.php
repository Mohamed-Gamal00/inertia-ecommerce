<?php

namespace App\Http\Requests\Dashboard\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'website_name'           => 'required',
            'website_name_en'        => 'nullable',
            'subscription_title'     => 'nullable',
            'image'                  => 'nullable|image',
            'logo'                   => 'nullable|image',
            'address'                => 'nullable',
            'phone_number'           => ['nullable', 'numeric'],
            'value_added_tax'        => ['nullable', 'numeric'],
            'tax_number'             => ['nullable', 'numeric'],
            'email'                  => 'nullable|email',
            'facebook'               => 'nullable',
            'twitter'                => 'nullable',
            'instagram'              => 'nullable',
            'snap'                   => 'nullable',
            'tiktok'                 => 'nullable',
            'order_status'           => 'nullable|exists:order_statuses,id',
            'publishable_key'        => 'nullable',
            'secret_key'             => 'nullable',

            // SEO
            'seo_meta_title'         => 'nullable|string|max:160',
            'seo_meta_description'   => 'nullable|string|max:320',
            'seo_meta_keywords'      => 'nullable|string|max:500',
            'og_title'               => 'nullable|string|max:160',
            'og_description'         => 'nullable|string|max:320',
            'og_image'               => 'nullable|image|max:2048',
            'twitter_card'           => 'nullable|in:summary,summary_large_image',
            'twitter_title'          => 'nullable|string|max:160',
            'twitter_description'    => 'nullable|string|max:320',
            'twitter_image'          => 'nullable|image|max:2048',
            'google_analytics_id'    => 'nullable|string|max:50',
            'google_tag_manager_id'  => 'nullable|string|max:50',
            'google_site_verification' => 'nullable|string|max:200',
            'canonical_url'          => 'nullable|url',
            'robots_index'           => 'nullable|in:index,follow,noindex,nofollow,index,nofollow,noindex,follow',
        ];

        return $rules;
    }
}
