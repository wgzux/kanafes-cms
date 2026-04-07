<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $medias = MediaItem::orderBy('sort_order')->get();
        return view('admin.media.index', compact('medias'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:youtube,facebook',
            'title'      => 'required|string|max:255',
            'url'        => 'required|string', // URL/iframe source
            'sort_order' => 'nullable|integer',
        ]);

        MediaItem::create([
            'type'       => $request->type,
            'title'      => $request->title,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.media.index')->with('success', 'Đã thêm phương tiện thành công!');
    }

    public function edit(MediaItem $medium)
    {
        return view('admin.media.edit', compact('medium'));
    }

    public function update(Request $request, MediaItem $medium)
    {
        $request->validate([
            'type'       => 'required|in:youtube,facebook',
            'title'      => 'required|string|max:255',
            'url'        => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $medium->update([
            'type'       => $request->type,
            'title'      => $request->title,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.media.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(MediaItem $medium)
    {
        $medium->delete();
        return redirect()->route('admin.media.index')->with('success', 'Đã xóa phương tiện.');
    }

    // Tạm giữ hàm cũ nếu routes/web.php còn dùng phương thức update kiểu cài đặt chung (không nên giữ nếu đã đổi resource)
}
