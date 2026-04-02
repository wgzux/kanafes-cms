@extends('admin.layout')
@section('title', 'Nội dung: ' . $pageName)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.page-contents.update', $page) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                @foreach($contents as $section => $item)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $item->label ?? $section }}
                        <span class="text-xs text-gray-400 font-normal ml-1">({{ $item->type }})</span>
                    </label>
                    @if($item->type === 'html')
                        <textarea name="{{ $section }}" rows="6"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-red-400 focus:border-transparent">{{ old($section, $item->value) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Hỗ trợ HTML tags: &lt;p&gt;, &lt;br&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;a&gt;...</p>
                    @else
                        <input type="text" name="{{ $section }}" value="{{ old($section, $item->value) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent">
                    @endif
                </div>
                @endforeach
            </div>
            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-medium hover:bg-red-700 transition">💾 Lưu thay đổi</button>
                <a href="{{ route('admin.page-contents.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">← Quay lại</a>
                <a href="{{ route($page === 'home' ? 'home' : $page) }}" target="_blank"
                   class="px-5 py-2.5 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50 transition text-sm">🌐 Xem trang</a>
            </div>
        </form>
    </div>
</div>
@endsection
