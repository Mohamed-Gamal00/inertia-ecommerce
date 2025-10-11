<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CommonQuestion;
use App\Models\Page;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{

    public function shipping_policy()
    {
        $page = Page::where('id', 2)->first();
        return view('front.static_pages.shipping_policy', compact('page'));
    }

    public function terms_conditions()
    {
        $page = Page::where('id', 1)->first();
        return view('front.static_pages.terms_conditions', compact('page'));
    }

    public function privacy_policy()
    {
        $page = Page::where('id', 3)->first();
        return view('front.static_pages.privacy_policy', compact('page'));
    }

    public function Exchanges_and_returns()
    {
        $page = Page::where('id', 5)->first();
        return view('front.static_pages.Exchanges_and_returns', compact('page'));
    }

    public function questions()
    {
        $questions = CommonQuestion::all();
        // dd($questions);
        return view('front.static_pages.questions', compact('questions'));
    }
}
