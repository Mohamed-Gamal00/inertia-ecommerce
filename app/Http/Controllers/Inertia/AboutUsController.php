<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $about_us = Page::where('id', 4)->first();
        return view('front.info.aboutus', compact('about_us'));
    }
}
