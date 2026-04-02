<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $youtube  = SiteSetting::get('youtube_url');
        $facebook = SiteSetting::get('facebook_post_url');
        $ytTitle  = SiteSetting::get('youtube_title',  '神奈川県公式YOUTUBEチャンネル');
        $fbTitle  = SiteSetting::get('facebook_title', '公式FACEBOOK');

        return view('admin.media.index', compact('youtube', 'facebook', 'ytTitle', 'fbTitle'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'youtube_url'      => 'nullable|url',
            'facebook_post_url'=> 'nullable|url',
            'youtube_title'    => 'nullable|string|max:255',
            'facebook_title'   => 'nullable|string|max:255',
        ]);

        SiteSetting::set('youtube_url',       $request->youtube_url);
        SiteSetting::set('facebook_post_url', $request->facebook_post_url);
        SiteSetting::set('youtube_title',     $request->youtube_title);
        SiteSetting::set('facebook_title',    $request->facebook_title);

        return redirect()->route('admin.media.index')
            ->with('success', 'Đường dẫn truyền thông đã được cập nhật!');
    }
}
