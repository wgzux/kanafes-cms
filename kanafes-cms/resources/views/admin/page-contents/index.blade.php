@extends('admin.layout')
@section('title', 'Quản lý nội dung trang')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($pages as $key => $label)
    <a href="{{ route('admin.page-contents.edit', $key) }}"
       class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-red-300 border-2 border-transparent transition group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-2xl group-hover:bg-red-100 transition">
                @switch($key)
                    @case('home')    🏠 @break
                    @case('about')   ℹ️ @break
                    @case('event')   🎌 @break
                    @case('map')     🗺️ @break
                    @case('sponsor') 🤝 @break
                    @default         📄
                @endswitch
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $label }}</p>
                <p class="text-xs text-gray-400 mt-0.5">/{{ $key }}</p>
            </div>
        </div>
        <p class="text-xs text-red-500 mt-4 group-hover:underline">Chỉnh sửa nội dung →</p>
    </a>
    @endforeach
</div>
@endsection
