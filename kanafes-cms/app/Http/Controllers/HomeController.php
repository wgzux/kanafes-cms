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
        $youtube    = SiteSetting::get('youtube_url');
        $facebook   = SiteSetting::get('facebook_post_url');
        $ytTitle    = SiteSetting::get('youtube_title',   '神奈川県公式YOUTUBEチャンネル');
        $fbTitle    = SiteSetting::get('facebook_title',  '公式FACEBOOK');

        $gallery    = GalleryImage::active()->get();
        $sponsors   = Sponsor::active()->get()->groupBy('tier');

        return view('home', compact(
            'bannerUrl', 'content', 'youtube', 'facebook',
            'ytTitle', 'fbTitle', 'gallery', 'sponsors'
        ));
    }
}
