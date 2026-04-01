<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $setting = cache()->remember('site_settings', 3600, fn() => Setting::first());

        return [
            ...parent::share($request),

            'auth.user' => fn() => Auth::guard('web')->check()
                ? Auth::guard('web')->user()->only('id', 'first_name', 'family_name', 'phone_number', 'email', 'image_url')
                : null,

            'flash' => [
                'success' => $request->session()->get('success'),
                'error'   => $request->session()->get('error'),
            ],

            // Global SEO — available in every Inertia page via usePage().props.seo
            'seo' => [
                'site_name'               => $setting?->website_name ?? config('app.name'),
                'meta_title'              => $setting?->seo_meta_title,
                'meta_description'        => $setting?->seo_meta_description,
                'meta_keywords'           => $setting?->seo_meta_keywords,
                'og_title'                => $setting?->og_title,
                'og_description'          => $setting?->og_description,
                'og_image'                => $setting?->og_image ? asset('storage/' . $setting->og_image) : null,
                'twitter_card'            => $setting?->twitter_card ?? 'summary_large_image',
                'twitter_title'           => $setting?->twitter_title,
                'twitter_description'     => $setting?->twitter_description,
                'twitter_image'           => $setting?->twitter_image ? asset('storage/' . $setting->twitter_image) : null,
                'google_analytics_id'     => $setting?->google_analytics_id,
                'google_tag_manager_id'   => $setting?->google_tag_manager_id,
                'google_site_verification'=> $setting?->google_site_verification,
                'canonical_url'           => $setting?->canonical_url,
                'robots_index'            => $setting?->robots_index ?? 'index,follow',
            ],
        ];
    }
}
