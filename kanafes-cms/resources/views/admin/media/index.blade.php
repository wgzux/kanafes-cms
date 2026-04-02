@extends('admin.layout')
@section('title', 'Quản lý Video & Mạng xã hội')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.media.update') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">🎬 Tiêu đề YouTube</label>
                    <input type="text" name="youtube_title" value="{{ old('youtube_title', $ytTitle) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                </div>
                <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">🔗 Link YouTube (embed)</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $youtube) }}"
                           placeholder="https://www.youtube.com/embed/VIDEO_ID"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">⚠️ Phải ở dạng: https://www.youtube.com/embed/ID_VIDEO</p>
                    @if($youtube)
                        <div class="mt-3">
                            <p class="text-xs text-gray-600 mb-1">Xem trước:</p>
                            <iframe src="{{ $youtube }}" class="w-full h-40 rounded-lg" allowfullscreen loading="lazy"></iframe>
                        </div>
                    @endif
                </div>

                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">📘 Tiêu đề Facebook</label>
                    <input type="text" name="facebook_title" value="{{ old('facebook_title', $fbTitle) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </div>
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">🔗 Link Facebook Post (embed)</label>
                    <textarea name="facebook_post_url" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent">{{ old('facebook_post_url', $facebook) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">⚠️ Dùng link từ Facebook Plugin → Embed Post</p>
                </div>
            </div>
            <button type="submit" class="mt-6 w-full bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                💾 Lưu cập nhật
            </button>
        </form>
    </div>
</div>
@endsection
