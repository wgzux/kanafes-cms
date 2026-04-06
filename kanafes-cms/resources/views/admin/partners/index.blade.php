@extends('admin.layout')
@section('title', 'Công ty đối tác (協力)')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $partners->count() }} công ty đối tác</p>
    <a href="{{ route('admin.partners.create') }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
        + Thêm công ty đối tác
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if($partners->isNotEmpty())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Logo / Tên</th>
                    <th class="px-4 py-3 text-left">Website</th>
                    <th class="px-4 py-3 text-center w-20">Thứ tự</th>
                    <th class="px-4 py-3 text-center w-24">Trạng thái</th>
                    <th class="px-4 py-3 text-right w-36">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($partners as $partner)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($partner->logo)
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}"
                                     class="h-12 w-20 object-contain rounded border bg-gray-50 p-1">
                            @else
                                <div class="h-12 w-20 bg-gray-100 rounded border flex items-center justify-center text-gray-400 text-xs">No logo</div>
                            @endif
                            <span class="font-medium text-gray-800 whitespace-pre-line">{{ $partner->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">
                        @if($partner->website_url)
                            <a href="{{ $partner->website_url }}" target="_blank"
                               class="text-blue-500 hover:underline truncate max-w-xs block">
                                {{ $partner->website_url }}
                            </a>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-gray-500">{{ $partner->sort_order }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $partner->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $partner->is_active ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.partners.edit', $partner) }}"
                               class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg transition">✏️ Sửa</a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST"
                                  onsubmit="return confirm('Xóa công ty đối tác {{ addslashes($partner->name) }}?')">
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
            <span class="text-5xl">🤝</span>
            <p class="mt-3 text-lg font-medium">Chưa có công ty đối tác nào</p>
            <a href="{{ route('admin.partners.create') }}" class="mt-4 inline-block text-red-600 hover:underline text-sm">Thêm đối tác đầu tiên →</a>
        </div>
    @endif
</div>
@endsection
