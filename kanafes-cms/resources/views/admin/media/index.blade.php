@extends('admin.layout')
@section('title', 'Quản lý Video & Mạng xã hội')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $medias->count() }} mục truyền thông</p>
    <a href="{{ route('admin.media.create') }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
        + Thêm mục mới
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if($medias->isNotEmpty())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-24">Loại</th>
                    <th class="px-4 py-3 text-left">Tiêu đề & URL</th>
                    <th class="px-4 py-3 text-center w-20">Thứ tự</th>
                    <th class="px-4 py-3 text-center w-24">Trạng thái</th>
                    <th class="px-4 py-3 text-right w-36">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($medias as $media)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($media->type === 'youtube')
                            <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">🎬 YouTube</span>
                        @else
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">📘 Facebook</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $media->title }}</div>
                        <a href="{{ $media->type === 'facebook' ? '#' : $media->url }}"
                           target="_blank" class="text-xs text-blue-500 hover:underline truncate max-w-sm block mt-1">
                            {{ Str::limit($media->url, 80) }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-center text-gray-500">{{ $media->sort_order }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $media->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $media->is_active ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.media.edit', $media) }}"
                               class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg transition">✏️ Sửa</a>
                            <form action="{{ route('admin.media.destroy', $media) }}" method="POST"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa mục này?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">🗑️ Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-16 text-center text-gray-400">
            <span class="text-5xl">ℹ️</span>
            <p class="mt-3 text-lg font-medium">Chưa có mục truyền thông nào</p>
            <a href="{{ route('admin.media.create') }}" class="mt-4 inline-block text-red-600 hover:underline text-sm">Thêm ngay →</a>
        </div>
    @endif
</div>
@endsection
