<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\Sponsor;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'gallery_count'  => GalleryImage::count(),
            'sponsor_count'  => Sponsor::count(),
            'active_gallery' => GalleryImage::where('is_active', true)->count(),
            'active_sponsors'=> Sponsor::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
