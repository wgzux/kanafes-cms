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
                <p class="px-3 pt-4 pb-1 text-xs font-semibold text-red-300 uppercase tracking-wider">Quản lý trang</p>
                <a href="{{ route('admin.about-page.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.about-page*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>📋</span> Tổng quan sự kiện
                </a>
                <a href="{{ route('admin.event-page.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.event-page*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🎌</span> Giới thiệu sự kiện
                </a>
                <a href="{{ route('admin.map-page.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.map-page*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🗺️</span> Bản đồ & Gian hàng
                </a>
                <p class="px-3 pt-4 pb-1 text-xs font-semibold text-red-300 uppercase tracking-wider">Quản lý khác</p>
                <a href="{{ route('admin.sponsors.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.sponsors*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🤝</span> Nhà tài trợ
                </a>
                <a href="{{ route('admin.partners.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.partners*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>🏢</span> Công ty đối tác
                </a>
                <a href="{{ route('admin.page-contents.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.page-contents*') ? 'bg-white text-red-700' : 'hover:bg-red-600 text-red-100' }}">
                    <span>📝</span> Nội dung trang
                </a>
                <div class="pt-4 border-t border-red-600 mt-4 space-y-1">
                    {{-- Export Static Website Button --}}
                    <a href="{{ route('admin.export-static') }}"
                       id="btn-export-static"
                       onclick="startExportLoading(event)"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition bg-yellow-500 text-gray-900 hover:bg-yellow-400">
                        <span id="export-icon">📦</span>
                        <span id="export-label">Xuất Website (.zip)</span>
                    </a>
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-red-200 hover:bg-red-600 transition">
                        <span>🌐</span> Xem trang chủ
                    </a>
                </div>
                <script>
                    function startExportLoading(e) {
                        var btn   = document.getElementById('btn-export-static');
                        var icon  = document.getElementById('export-icon');
                        var label = document.getElementById('export-label');
                        // Prevent double-click
                        if (btn.dataset.loading === '1') { e.preventDefault(); return; }
                        btn.dataset.loading = '1';
                        btn.classList.add('opacity-70', 'cursor-wait');
                        icon.textContent  = '⏳';
                        label.textContent = 'Đang xuất… vui lòng chờ';
                        // Re-enable after 90 seconds (safety reset)
                        setTimeout(function () {
                            btn.dataset.loading = '0';
                            btn.classList.remove('opacity-70', 'cursor-wait');
                            icon.textContent  = '📦';
                            label.textContent = 'Xuất Website (.zip)';
                        }, 90000);
                    }
                </script>
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
