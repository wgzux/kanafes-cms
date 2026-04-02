<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order')->get();
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $maxOrder = GalleryImage::max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('gallery', $filename, 'public');

            GalleryImage::create([
                'filename'   => $filename,
                'alt_text'   => $file->getClientOriginalName(),
                'sort_order' => ++$maxOrder,
                'is_active'  => true,
            ]);
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Đã tải lên ' . count($request->file('images')) . ' ảnh thành công!');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'alt_text'  => 'nullable|string|max:255',
            'caption'   => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('gallery/' . $gallery->filename);
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('gallery', $filename, 'public');
            $gallery->filename = $filename;
        }

        $gallery->update([
            'alt_text'   => $request->alt_text,
            'caption'    => $request->caption,
            'is_active'  => $request->boolean('is_active'),
            'filename'   => $gallery->filename,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Ảnh đã được cập nhật!');
    }

    public function destroy(GalleryImage $gallery)
    {
        Storage::disk('public')->delete('gallery/' . $gallery->filename);
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Đã xóa ảnh.');
    }

    /**
     * API endpoint để cập nhật thứ tự ảnh (drag & drop)
     */
    public function updateOrder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            GalleryImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
