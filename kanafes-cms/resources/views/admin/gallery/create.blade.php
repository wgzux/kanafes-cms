@extends('admin.layout')
@section('title', 'Tải lên ảnh mới')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-red-400 transition mb-6" id="drop-zone">
                <span class="text-5xl">📁</span>
                <p class="text-gray-600 mt-3">Kéo thả nhiều ảnh vào đây hoặc</p>
                <label for="images" class="mt-2 inline-block cursor-pointer text-red-600 font-medium hover:underline">
                    Chọn file ảnh
                </label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple class="hidden" onchange="previewImages(this)">
                <p class="text-xs text-gray-400 mt-2">Hỗ trợ nhiều ảnh cùng lúc — JPG, PNG, WebP tối đa 5MB/ảnh</p>
            </div>

            <div id="preview-grid" class="grid grid-cols-3 gap-3 mb-6 hidden"></div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                    📤 Tải lên
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-center">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImages(input) {
    const grid = document.getElementById('preview-grid');
    grid.innerHTML = '';
    grid.classList.remove('hidden');
    [...input.files].forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative rounded-lg overflow-hidden';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-24 object-cover">
                <p class="text-xs text-gray-500 truncate mt-1 px-1">${file.name}</p>`;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
