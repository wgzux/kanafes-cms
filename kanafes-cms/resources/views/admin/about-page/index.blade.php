@extends('admin.layout')
@section('title', 'Quản lý trang Tổng quan sự kiện')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.about-page.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tiêu đề trang --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Thông tin sự kiện</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề trang</label>
                    <input type="text" name="page_title" value="{{ $content['page_title'] ?? '開催概要' }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">📅 Ngày tổ chức</label>
                        <input type="text" name="event_date" value="{{ $content['event_date'] ?? '2025.11.15(土), 16(日)' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">⏰ Thời gian</label>
                        <input type="text" name="event_time" value="{{ $content['event_time'] ?? '11:00～21:00' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">📍 Địa điểm (hỗ trợ HTML)</label>
                    <textarea name="event_venue" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ $content['event_venue'] ?? '統一公園前広場、チャン・ニャン・トン通り<br/>Khu vực trước cổng công viên Thống Nhất, phố Trần Nhân Tông' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Ảnh địa điểm --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🖼️ Ảnh địa điểm</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Ảnh 1 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh cổng công viên</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        @if($venueImage1)
                            <img src="{{ asset('storage/about/' . $venueImage1) }}" class="max-h-40 mx-auto mb-2 rounded">
                        @else
                            <img src="{{ asset('assets/images/map-park.jpg') }}" class="max-h-40 mx-auto mb-2 rounded opacity-60">
                            <p class="text-xs text-gray-400">Ảnh mặc định từ bản gốc</p>
                        @endif
                        <input type="file" name="venue_image_1" accept="image/*"
                               class="mt-2 text-sm text-gray-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:font-medium hover:file:bg-red-100">
                    </div>
                </div>

                {{-- Ảnh 2 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh bản đồ khu vực</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        @if($venueImage2)
                            <img src="{{ asset('storage/about/' . $venueImage2) }}" class="max-h-40 mx-auto mb-2 rounded">
                        @else
                            <img src="{{ asset('assets/images/map.png') }}" class="max-h-40 mx-auto mb-2 rounded opacity-60">
                            <p class="text-xs text-gray-400">Ảnh mặc định từ bản gốc</p>
                        @endif
                        <input type="file" name="venue_image_2" accept="image/*"
                               class="mt-2 text-sm text-gray-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:font-medium hover:file:bg-red-100">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition shadow-sm">
            💾 Lưu thay đổi
        </button>
    </form>
</div>
@endsection
