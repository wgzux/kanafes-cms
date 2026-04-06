@extends('admin.layout')
@section('title', 'Quản lý trang Bản đồ & Gian hàng')

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- PHẦN 1: Upload bản đồ --}}
    <form action="{{ route('admin.map-page.update-map') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🗺️ Ảnh bản đồ</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                @if($mapImage)
                    <img src="{{ asset('storage/map/' . $mapImage) }}" class="max-h-64 mx-auto mb-3 rounded">
                @else
                    <img src="{{ asset('assets/images/map-kanagawa.png') }}" class="max-h-64 mx-auto mb-3 rounded opacity-60">
                    <p class="text-xs text-gray-400 mb-2">Ảnh mặc định từ bản gốc</p>
                @endif
                <input type="file" name="map_image" accept="image/*"
                       class="text-sm text-gray-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:font-medium hover:file:bg-red-100">
            </div>
            <button type="submit" class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                💾 Cập nhật bản đồ
            </button>
        </div>
    </form>

    {{-- PHẦN 2: Thêm nhóm gian hàng mới --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">📦 Nhóm gian hàng</h3>
            <button type="button" onclick="document.getElementById('add-group-form').classList.toggle('hidden')"
                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                ＋ Thêm nhóm mới
            </button>
        </div>

        <div id="add-group-form" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border">
            <form action="{{ route('admin.map-page.store-group') }}" method="POST">
                @csrf
                <div class="flex items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên nhóm</label>
                        <input type="text" name="group_name" required placeholder="VD: 企業ブース"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">🎨 Màu sắc</label>
                        <input type="color" name="group_color" value="#8B0000"
                               class="h-10 w-16 cursor-pointer rounded border border-gray-300">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition whitespace-nowrap">
                        ✅ Tạo nhóm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- PHẦN 3: Danh sách từng nhóm --}}
    @foreach($groups as $group)
        @php $groupBooths = $booths[$group->group_name] ?? collect(); @endphp
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            {{-- Group Header --}}
            <div class="px-6 py-4 flex items-center justify-between" style="background-color: {{ $group->group_color }}20; border-left: 4px solid {{ $group->group_color }}">
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded" style="background-color: {{ $group->group_color }}"></div>
                    <h4 class="font-semibold text-gray-800">{{ $group->group_name }}</h4>
                    <span class="text-xs text-gray-500">({{ $groupBooths->count() }} gian hàng)</span>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Nút sửa nhóm --}}
                    <button type="button" onclick="document.getElementById('edit-group-{{ $loop->index }}').classList.toggle('hidden')"
                            class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-lg hover:bg-blue-200 transition">✏️ Sửa nhóm</button>
                    {{-- Nút xóa nhóm --}}
                    <form action="{{ route('admin.map-page.destroy-group') }}" method="POST"
                          onsubmit="return confirm('⚠️ Xóa nhóm này sẽ xóa TẤT CẢ gian hàng bên trong. Tiếp tục?')">
                        @csrf @method('DELETE')
                        <input type="hidden" name="group_name" value="{{ $group->group_name }}">
                        <button class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-lg hover:bg-red-200 transition">🗑️ Xóa nhóm</button>
                    </form>
                </div>
            </div>

            {{-- Form sửa nhóm (ẩn) --}}
            <div id="edit-group-{{ $loop->index }}" class="hidden px-6 py-3 bg-yellow-50 border-b">
                <form action="{{ route('admin.map-page.update-group') }}" method="POST" class="flex items-end gap-4">
                    @csrf @method('PUT')
                    <input type="hidden" name="old_group_name" value="{{ $group->group_name }}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tên nhóm mới</label>
                        <input type="text" name="group_name" value="{{ $group->group_name }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Màu mới</label>
                        <input type="color" name="group_color" value="{{ $group->group_color }}"
                               class="h-10 w-14 cursor-pointer rounded border border-gray-300">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">💾</button>
                </form>
            </div>

            {{-- Bảng gian hàng --}}
            <div class="px-6 py-3">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2 w-20">Số</th>
                            <th class="py-2">Tên gian hàng</th>
                            <th class="py-2 w-32 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupBooths as $booth)
                        <tr class="border-b border-gray-100 hover:bg-gray-50" id="booth-row-{{ $booth->id }}">
                            <td class="py-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-white text-xs font-bold"
                                      style="background-color: {{ $group->group_color }}">{{ $booth->booth_number }}</span>
                            </td>
                            <td class="py-2 text-gray-700">{{ $booth->booth_name }}</td>
                            <td class="py-2 text-right">
                                <button type="button" onclick="document.getElementById('edit-booth-{{ $booth->id }}').classList.toggle('hidden')"
                                        class="text-blue-600 hover:text-blue-800 text-xs mr-2">✏️</button>
                                <form action="{{ route('admin.map-page.destroy-booth', $booth) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Xóa gian hàng này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 text-xs">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        {{-- Form sửa inline --}}
                        <tr id="edit-booth-{{ $booth->id }}" class="hidden">
                            <td colspan="3" class="py-2">
                                <form action="{{ route('admin.map-page.update-booth', $booth) }}" method="POST" class="flex items-center gap-3 bg-yellow-50 p-3 rounded-lg">
                                    @csrf @method('PUT')
                                    <input type="text" name="booth_number" value="{{ $booth->booth_number }}" class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center">
                                    <input type="text" name="booth_name" value="{{ $booth->booth_name }}" class="flex-1 border border-gray-300 rounded px-3 py-1 text-sm">
                                    <button type="submit" class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">💾</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Thêm gian hàng mới vào nhóm --}}
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <button type="button" onclick="document.getElementById('add-booth-{{ $loop->index }}').classList.toggle('hidden')"
                            class="text-green-600 hover:text-green-800 text-sm font-medium">＋ Thêm gian hàng vào nhóm này</button>
                    <div id="add-booth-{{ $loop->index }}" class="hidden mt-2">
                        <form action="{{ route('admin.map-page.store-booth') }}" method="POST" class="flex items-center gap-3 bg-green-50 p-3 rounded-lg">
                            @csrf
                            <input type="hidden" name="group_name" value="{{ $group->group_name }}">
                            <input type="text" name="booth_number" required placeholder="Số" class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center">
                            <input type="text" name="booth_name" required placeholder="Tên gian hàng" class="flex-1 border border-gray-300 rounded px-3 py-1 text-sm">
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">✅</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
