<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard') — Kanagawa Festival CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-red-700 text-white flex flex-col shadow-xl flex-shrink-0">
            <!-- Logo -->
            <div class="p-5 border-b border-red-600">
                <h1 class="text-lg font-bold leading-tight">🎌 Kanafest</h1>
                <p class="text-xs text-red-200 mt-1">Admin Dashboard</p>
            </div>
            <!-- Nav -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>📊</span> Tổng quan
                </a>
                <p class="px-3 pt-4 pb-1 text-xs font-semibold text-red-300 uppercase tracking-wider">Trang chủ</p>
                <a href="{{ route('admin.banner.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.banner*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🖼️</span> Ảnh bìa (Banner)
                </a>
                <a href="{{ route('admin.gallery.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.gallery*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>📸</span> Thư viện ảnh
                </a>
                <a href="{{ route('admin.media.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.media*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🎬</span> Video & Mạng xã hội
                </a>
                <p class="px-3 pt-4 pb-1 text-xs font-semibold text-red-300 uppercase tracking-wider">Quản lý</p>
                <a href="{{ route('admin.sponsors.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.sponsors*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🤝</span> Nhà tài trợ
                </a>
                <a href="{{ route('admin.page-contents.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.page-contents*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>📝</span> Nội dung trang
                </a>
                <div class="pt-4 border-t border-red-600 mt-4">
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-red-200 hover:bg-red-600 transition">
                        <span>🌐</span> Xem trang chủ
                    </a>
                </div>
            </nav>
            <!-- User -->
            <div class="p-4 border-t border-red-600">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-red-300 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Đăng xuất" class="text-red-300 hover:text-white transition text-lg">⏻</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between flex-shrink-0">
                <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-2 text-green-800 text-sm">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-2 text-red-800 text-sm">
                        <span>❌</span> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                        <p class="font-medium mb-1">⚠️ Có lỗi xảy ra:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
