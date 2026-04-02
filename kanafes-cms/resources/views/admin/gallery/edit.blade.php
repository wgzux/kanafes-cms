@extends('admin.layout')
@section('title', 'Chỉnh sửa ảnh')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-6">
            <img src="{{ $gallery->url }}" alt="{{ $gallery->alt_text }}" class="w-full h-48 object-cover rounded-lg border">
        </div>
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thay ảnh mới (tùy chọn)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text (mô tả ảnh)</label>
                    <input type="text" name="alt_text" value="{{ old('alt_text', $gallery->alt_text) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Caption (chú thích)</label>
                    <input type="text" name="caption" value="{{ old('caption', $gallery->caption) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $gallery->is_active ? 'checked' : '' }}
                           class="w-4 h-4 text-red-600 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Hiển thị ảnh này trên trang chủ</label>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">💾 Lưu</button>
                <a href="{{ route('admin.gallery.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection
