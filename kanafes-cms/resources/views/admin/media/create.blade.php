@extends('admin.layout')
@section('title', 'Thêm Video / Mạng xã hội')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.media.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Loại (*) </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="youtube" required checked class="text-red-600 focus:ring-red-500">
                            <span class="text-sm">🎬 YouTube</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="facebook" required class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">📘 Facebook</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề hiển thị (*) </label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL nhúng (Embed Link) (*) </label>
                    <textarea name="url" required rows="3"
                              placeholder="https://www.youtube.com/embed/VIDEO_ID"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">{{ old('url') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">
                        - <b>YouTube</b>: https://www.youtube.com/embed/... <br>
                        - <b>Facebook</b>: Lấy từ mục "Mã nhúng" (src) bài post Facebook.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400">
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="w-4 h-4 text-red-600 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Trạng thái (Hiển thị/Ẩn)</label>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                    💾 Thêm mới
                </button>
                <a href="{{ route('admin.media.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection
