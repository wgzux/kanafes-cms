@extends('admin.layout')
@section('title', 'Quản lý trang Giới thiệu sự kiện')

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- PHẦN 1: Nội dung mô tả + Lịch --}}
    <form action="{{ route('admin.event-page.update-content') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📝 Nội dung trang</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề trang</label>
                    <input type="text" name="page_title" value="{{ $content['page_title'] ?? 'イベント情報' }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả sự kiện (hỗ trợ HTML)</label>
                    <textarea name="event_description" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ $content['event_description'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giới thiệu Special Supporter (hỗ trợ HTML)</label>
                    <textarea name="supporter_intro" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ $content['supporter_intro'] ?? '' }}</textarea>
                </div>

                {{-- Upload Calendar Images --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📅 Lịch sự kiện - Thứ 7</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center">
                            @if($calendarImage1)
                                <img src="{{ asset('storage/event/' . $calendarImage1) }}" class="max-h-32 mx-auto mb-2 rounded">
                            @else
                                <img src="{{ asset('assets/images/event-calendar-1.jpg') }}" class="max-h-32 mx-auto mb-2 rounded opacity-60">
                                <p class="text-xs text-gray-400">Ảnh mặc định</p>
                            @endif
                            <input type="file" name="calendar_image_1" accept="image/*" class="mt-1 text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:font-medium">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📅 Lịch sự kiện - Chủ nhật</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center">
                            @if($calendarImage2)
                                <img src="{{ asset('storage/event/' . $calendarImage2) }}" class="max-h-32 mx-auto mb-2 rounded">
                            @else
                                <img src="{{ asset('assets/images/event-calendar-2.jpg') }}" class="max-h-32 mx-auto mb-2 rounded opacity-60">
                                <p class="text-xs text-gray-400">Ảnh mặc định</p>
                            @endif
                            <input type="file" name="calendar_image_2" accept="image/*" class="mt-1 text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:font-medium">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                💾 Lưu nội dung
            </button>
        </div>
    </form>

    {{-- PHẦN 2: Quản lý nghệ sĩ theo 3 loại --}}
    @foreach(['ambassador' => $ambassadors, 'supporter' => $supporters, 'guest' => $guests] as $catKey => $performers)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    @if($catKey === 'ambassador') 🎤 @elseif($catKey === 'supporter') 🌟 @else 🎭 @endif
                    {{ $categories[$catKey]['label'] }}
                </h3>
                <button type="button" onclick="document.getElementById('add-{{ $catKey }}').classList.toggle('hidden')"
                        class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                    ＋ Thêm
                </button>
            </div>

            {{-- Form thêm mới (ẩn mặc định) --}}
            <div id="add-{{ $catKey }}" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border">
                <form action="{{ route('admin.event-page.store-performer') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="{{ $catKey }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                            <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                            <input type="file" name="image" accept="image/*" class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                    <button type="submit" class="mt-3 px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                        ✅ Lưu
                    </button>
                </form>
            </div>

            {{-- Danh sách hiện tại --}}
            @forelse($performers as $p)
                <div class="flex items-start gap-4 p-4 mb-3 bg-gray-50 rounded-lg border" id="performer-{{ $p->id }}">
                    {{-- Ảnh --}}
                    <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                        @if($p->image)
                            <img src="{{ $p->image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-2xl">📷</div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-800">{{ $p->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($p->description, 120) }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2 flex-shrink-0">
                        <button type="button" onclick="document.getElementById('edit-{{ $p->id }}').classList.toggle('hidden')"
                                class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-lg hover:bg-blue-200 transition">✏️ Sửa</button>
                        <form action="{{ route('admin.event-page.destroy-performer', $p) }}" method="POST"
                              onsubmit="return confirm('Xóa nghệ sĩ này?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-lg hover:bg-red-200 transition">🗑️</button>
                        </form>
                    </div>
                </div>

                {{-- Form sửa (ẩn mặc định) --}}
                <div id="edit-{{ $p->id }}" class="hidden mb-3 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <form action="{{ route('admin.event-page.update-performer', $p) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                                <input type="text" name="name" value="{{ $p->name }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Thay ảnh (tùy chọn)</label>
                                <input type="file" name="image" accept="image/*" class="text-sm text-gray-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-yellow-100 file:text-yellow-700">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500">{{ $p->description }}</textarea>
                        </div>
                        <button type="submit" class="mt-3 px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">
                            💾 Cập nhật
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-400 text-sm italic">Chưa có nghệ sĩ nào trong mục này.</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
