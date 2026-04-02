@extends('admin.layout')
@section('title', 'Nhà tài trợ')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $sponsors->count() }} nhà tài trợ</p>
    <a href="{{ route('admin.sponsors.create') }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
        + Thêm nhà tài trợ
    </a>
</div>

@foreach(['diamond','gold','silver','bronze'] as $tier)
    @if($sponsors->where('tier', $tier)->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                <span class="{{ $tiers[$tier]['color'] }} px-2 py-0.5 rounded-full text-xs">{{ $tiers[$tier]['label'] }}</span>
            </h3>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Logo / Tên</th>
                            <th class="px-4 py-3 text-left">Website</th>
                            <th class="px-4 py-3 text-center">Trạng thái</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($sponsors->where('tier', $tier) as $sponsor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($sponsor->logo)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="h-10 w-16 object-contain rounded border">
                                    @else
                                        <div class="h-10 w-16 bg-gray-100 rounded border flex items-center justify-center text-gray-400 text-xs">No logo</div>
                                    @endif
                                    <span class="font-medium text-gray-800">{{ $sponsor->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                @if($sponsor->website_url)
                                    <a href="{{ $sponsor->website_url }}" target="_blank" class="text-blue-500 hover:underline truncate max-w-xs block">
                                        {{ $sponsor->website_url }}
                                    </a>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $sponsor->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $sponsor->is_active ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.sponsors.edit', $sponsor) }}"
                                       class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg transition">✏️ Sửa</a>
                                    <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST"
                                          onsubmit="return confirm('Xóa nhà tài trợ {{ $sponsor->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">🗑️ Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endforeach

@if($sponsors->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-16 text-center text-gray-400">
        <span class="text-5xl">🤝</span>
        <p class="mt-3 text-lg font-medium">Chưa có nhà tài trợ nào</p>
        <a href="{{ route('admin.sponsors.create') }}" class="mt-4 inline-block text-red-600 hover:underline text-sm">Thêm nhà tài trợ đầu tiên →</a>
    </div>
@endif
@endsection
