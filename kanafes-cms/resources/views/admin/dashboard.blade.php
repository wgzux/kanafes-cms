@extends('admin.layout')
@section('title', 'Tổng quan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Số ảnh Gallery</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['gallery_count'] }}</p>
        <p class="text-xs text-green-600 mt-1">{{ $stats['active_gallery'] }} đang hiển thị</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Nhà tài trợ</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['sponsor_count'] }}</p>
        <p class="text-xs text-green-600 mt-1">{{ $stats['active_sponsors'] }} đang hiển thị</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Trang được quản lý</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">5</p>
        <p class="text-xs text-gray-500 mt-1">home, about, event, map, sponsor</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Trạng thái hệ thống</p>
        <p class="text-2xl font-bold text-green-600 mt-1">🟢 Online</p>
        <p class="text-xs text-gray-500 mt-1">Kanafest CMS v1.0</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">⚡ Truy cập nhanh</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.banner.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-red-50 transition group">
                <span class="text-2xl mb-1">🖼️</span>
                <span class="text-xs font-medium text-gray-600 group-hover:text-red-600">Cập nhật Banner</span>
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-red-50 transition group">
                <span class="text-2xl mb-1">📸</span>
                <span class="text-xs font-medium text-gray-600 group-hover:text-red-600">Thêm ảnh mới</span>
            </a>
            <a href="{{ route('admin.sponsors.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-red-50 transition group">
                <span class="text-2xl mb-1">🤝</span>
                <span class="text-xs font-medium text-gray-600 group-hover:text-red-600">Thêm nhà tài trợ</span>
            </a>
            <a href="{{ route('admin.page-contents.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-red-50 transition group">
                <span class="text-2xl mb-1">📝</span>
                <span class="text-xs font-medium text-gray-600 group-hover:text-red-600">Sửa nội dung</span>
            </a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">📋 Ghi chú</h3>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex gap-2"><span class="text-blue-500">•</span> Ảnh bìa: kích thước khuyến nghị 1920x600px</li>
            <li class="flex gap-2"><span class="text-blue-500">•</span> Gallery: kéo thả để sắp xếp thứ tự</li>
            <li class="flex gap-2"><span class="text-blue-500">•</span> Logo nhà tài trợ Kim cương sẽ hiển thị lớn nhất</li>
            <li class="flex gap-2"><span class="text-blue-500">•</span> YouTube link phải ở dạng embed (/embed/...)</li>
            <li class="flex gap-2"><span class="text-green-500">✓</span> Mọi thay đổi cập nhật ngay lập tức lên trang web</li>
        </ul>
    </div>
</div>
@endsection
