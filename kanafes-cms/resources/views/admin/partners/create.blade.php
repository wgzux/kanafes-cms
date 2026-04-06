@extends('admin.layout')
@section('title', 'Thêm công ty đối tác')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tên công ty <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal">(Enter để xuống dòng, ví dụ: tên Nhật / tên Latin)</span>
                    </label>
                    <textarea name="name" required rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent"
                              placeholder="株式会社タカラ&#10;TAKARA">{{ old('name') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(this)"
                           class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600">
                    <img id="logo-preview" src="" class="mt-3 h-20 object-contain rounded border hidden">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                    <input type="url" name="website_url" value="{{ old('website_url') }}"
                           placeholder="https://example.com"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400">
                    <p class="text-xs text-gray-400 mt-1">Số nhỏ hơn hiển thị trước</p>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="w-4 h-4 text-red-600 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Hiển thị trên trang web</label>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                    💾 Thêm đối tác
                </button>
                <a href="{{ route('admin.partners.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logo-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
