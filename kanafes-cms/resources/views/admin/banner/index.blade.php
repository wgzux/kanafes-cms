@extends('admin.layout')
@section('title', 'Quản lý ảnh bìa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Preview ảnh hiện tại --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">🖼️ Ảnh bìa hiện tại</h3>
        @if($banner)
            <img src="{{ asset('storage/banners/' . $banner) }}" alt="Banner hiện tại"
                 class="w-full h-48 object-cover rounded-lg border" />
            <p class="text-xs text-gray-500 mt-2">File: {{ $banner }}</p>
        @else
            <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <span class="text-4xl">🖼️</span>
                    <p class="text-sm mt-2">Chưa có ảnh bìa tùy chỉnh</p>
                    <p class="text-xs">Đang dùng ảnh mặc định</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Upload form --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">📤 Tải lên ảnh bìa mới</h3>
        <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center mb-4 hover:border-red-400 transition"
                 id="drop-zone">
                <span class="text-4xl">📁</span>
                <p class="text-sm text-gray-600 mt-2">Kéo thả ảnh vào đây hoặc</p>
                <label for="banner" class="mt-2 inline-block cursor-pointer text-sm font-medium text-red-600 hover:text-red-700">
                    Chọn file từ máy tính
                </label>
                <input type="file" id="banner" name="banner" accept="image/*" class="hidden" onchange="previewImage(this)">
                <p class="text-xs text-gray-400 mt-2">JPG, PNG, WebP — Tối đa 5MB</p>
                <p class="text-xs text-gray-400">Kích thước khuyến nghị: 1920 x 600px</p>
            </div>

            {{-- Khung xem trước --}}
            <div id="preview-container" class="hidden mb-4">
                <p class="text-sm font-medium text-gray-700 mb-2">👁️ Xem trước:</p>
                <img id="preview-image" src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border-2 border-green-400">
                <p id="preview-name" class="text-xs text-gray-500 mt-1"></p>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                💾 Lưu ảnh bìa mới
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const container = document.getElementById('preview-container');
    const img = document.getElementById('preview-image');
    const name = document.getElementById('preview-name');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            name.textContent = 'File: ' + input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + 'MB)';
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag & drop support
const dropZone = document.getElementById('drop-zone');
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-red-400', 'bg-red-50'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-red-400', 'bg-red-50'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-red-400', 'bg-red-50');
    const input = document.getElementById('banner');
    input.files = e.dataTransfer.files;
    previewImage(input);
});
</script>
@endpush
