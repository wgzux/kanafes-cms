@extends('admin.layout')
@section('title', 'Thư viện ảnh')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $images->count() }} ảnh — Kéo thả để sắp xếp lại thứ tự</p>
    <a href="{{ route('admin.gallery.create') }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
        <span>+</span> Thêm ảnh mới
    </a>
</div>

@if($images->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-16 text-center text-gray-400">
        <span class="text-5xl">📷</span>
        <p class="mt-3 text-lg font-medium">Chưa có ảnh nào</p>
        <a href="{{ route('admin.gallery.create') }}" class="mt-4 inline-block text-red-600 hover:underline text-sm">Thêm ảnh đầu tiên →</a>
    </div>
@else
    <div class="bg-white rounded-xl shadow-sm p-4">
        <ul id="sortable-gallery" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($images as $image)
            <li class="relative group rounded-lg overflow-hidden border-2 border-transparent hover:border-red-400 transition cursor-grab"
                data-id="{{ $image->id }}">
                <img src="{{ $image->url }}" alt="{{ $image->alt_text }}"
                     class="w-full h-36 object-cover" loading="lazy">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                    <a href="{{ route('admin.gallery.edit', $image) }}"
                       class="bg-white text-gray-800 text-xs px-2 py-1 rounded-lg font-medium hover:bg-gray-100">✏️ Sửa</a>
                    <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST"
                          onsubmit="return confirm('Xóa ảnh này?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white text-xs px-2 py-1 rounded-lg hover:bg-red-700">🗑️ Xóa</button>
                    </form>
                </div>
                @if(!$image->is_active)
                    <span class="absolute top-2 left-2 bg-gray-800/70 text-white text-xs px-2 py-0.5 rounded-full">Ẩn</span>
                @endif
                <div class="absolute top-2 right-2 text-white text-xs bg-black/50 px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100">
                    ☰
                </div>
            </li>
            @endforeach
        </ul>
        <p class="text-xs text-gray-400 mt-4 text-center">Kéo thả ảnh để thay đổi thứ tự hiển thị. Thứ tự được lưu tự động.</p>
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const el = document.getElementById('sortable-gallery');
if (el) {
    Sortable.create(el, {
        animation: 150,
        ghostClass: 'opacity-30',
        onEnd: function() {
            const order = [...el.querySelectorAll('[data-id]')].map(el => el.dataset.id);
            fetch('{{ route("admin.gallery.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    // hiện thông báo nhỏ
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg text-sm shadow-lg z-50';
                    toast.textContent = '✅ Thứ tự đã được lưu!';
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2000);
                }
            });
        }
    });
}
</script>
@endpush
