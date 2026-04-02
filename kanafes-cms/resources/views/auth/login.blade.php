<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Kanagawa Festival CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-red-700 via-red-600 to-red-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-8 text-center">
                <div class="text-5xl mb-3">🎌</div>
                <h1 class="text-white text-xl font-bold">Kanagawa Festival</h1>
                <p class="text-red-200 text-sm mt-1">Admin Dashboard</p>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">
                <h2 class="text-gray-800 text-lg font-semibold mb-6 text-center">Đăng nhập</h2>

                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               autofocus placeholder="admin@kanafest.vn"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent outline-none transition
                                      @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                        <input type="password" id="password" name="password" required
                               placeholder="••••••••"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent outline-none transition">
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl transition duration-200 text-sm mt-2">
                        Đăng nhập →
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-red-500 transition">
                        ← Quay về trang chủ
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center text-red-200 text-xs mt-4">KANAGAWA FESTIVAL IN HANOI 2025 · CMS v1.0</p>
    </div>
</body>
</html>
