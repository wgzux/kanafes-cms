<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banner = SiteSetting::get('banner_image');
        return view('admin.banner.index', compact('banner'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'banner.required' => 'Vui lòng chọn file ảnh.',
            'banner.image'    => 'File phải là hình ảnh.',
            'banner.max'      => 'Ảnh không được vượt quá 5MB.',
        ]);

        // Xóa ảnh cũ nếu tồn tại
        $oldBanner = SiteSetting::get('banner_image');
        if ($oldBanner && Storage::disk('public')->exists('banners/' . $oldBanner)) {
            Storage::disk('public')->delete('banners/' . $oldBanner);
        }

        // Lưu ảnh mới
        $filename = time() . '_' . $request->file('banner')->getClientOriginalName();
        $request->file('banner')->storeAs('banners', $filename, 'public');

        SiteSetting::set('banner_image', $filename);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Ảnh bìa đã được cập nhật thành công!');
    }
}
