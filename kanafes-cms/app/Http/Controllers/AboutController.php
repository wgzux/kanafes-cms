<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('about');
        $venueImage1 = SiteSetting::get('about_venue_image_1');
        $venueImage2 = SiteSetting::get('about_venue_image_2');
        return view('about', compact('content', 'venueImage1', 'venueImage2'));
    }
}
