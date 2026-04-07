<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Models\Sponsor;

class HomeController extends Controller
{
    public function index()
    {
        $banner     = SiteSetting::get('banner_image');
        $bannerUrl  = $banner ? asset('storage/banners/' . $banner) : asset('assets/images/web-kanagwa.jpg');

        $content    = PageContent::getPage('home');
        $medias     = \App\Models\MediaItem::active()->get();

        $gallery    = GalleryImage::active()->get();
        $sponsors   = Sponsor::active()->get()->groupBy('tier');

        return view('home', compact(
            'bannerUrl', 'content', 'medias', 'gallery', 'sponsors'
        ));
    }
}
