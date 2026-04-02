<!DOCTYPE html>
<html lang="ja" xml:lang="ja">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'KANAGAWA FESTIVAL IN HANOI 2025')</title>
    <meta name="description" content="@yield('description', 'Kanagawa Festival in Hanoi 2025 - Lễ hội kết nối văn hóa Việt Nhật')">
    <meta property="og:title" content="@yield('title', 'KANAGAWA FESTIVAL IN HANOI 2025')" />
    <meta property="og:description" content="@yield('description', 'Kanagawa Festival in Hanoi 2025')" />
    <meta property="og:type" content="website" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">
    <link href="{{ asset('assets/css/venobox.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body>
    <div class="page">
        <div class="page__container">
            <!-- HEADER -->
            <header class="header">
                <div class="container header__logo-container">
                    <a href="{{ route('home') }}" class="header__logo-container-link">
                        <img class="header__logo" src="{{ asset('assets/images/kanafest-main-logo.png') }}" alt="Kanagawa Festival Logo" />
                    </a>
                    <img class="header__logo-cherry-blossom"
                        src="{{ asset('assets/images/kanafest-cherry-blossom-logo.png') }}"
                        alt="Kanagawa Festival Cherry Blossom Logo" />
                    <div class="header__nav-bar">
                        <nav class="nav nav__item--home" aria-label="Home">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">ホーム</a>
                        </nav>
                        <nav class="nav nav__item--overview" aria-label="About Us">
                            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">開催概要</a>
                        </nav>
                        <nav class="nav nav__item--events" aria-label="Events">
                            <a href="{{ route('event') }}" class="{{ request()->routeIs('event') ? 'active' : '' }}">イベント情報</a>
                        </nav>
                        <nav class="nav nav__item--map" aria-label="Map">
                            <a href="{{ route('map') }}" class="{{ request()->routeIs('map') ? 'active' : '' }}">会場マップ</a>
                        </nav>
                        <nav class="nav nav__item--sponsors" aria-label="Sponsors">
                            <a href="{{ route('sponsor') }}" class="{{ request()->routeIs('sponsor') ? 'active' : '' }}">協賛企業</a>
                        </nav>
                    </div>
                    <button class="mobile-menu-toggle" aria-label="Open menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </header>

            @yield('content')

            <!-- FOOTER -->
            <footer class="footer">
                <div class="footer__organizer">
                    <div class="footer__organizer-label">主催</div>
                    <div class="footer__organizer-text">
                        ハノイ市人民委員会／ベトナムフェスタin神奈川実行委員会<br />
                        （実行委員会事務局：神奈川県文化スポーツ観光局国際課企画グループ)
                    </div>
                </div>
                <div class="footer__border"></div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
