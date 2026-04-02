@extends('layouts.app')
@section('title', 'KANAGAWA FESTIVAL IN HANOI 2025')

@section('content')
    <!-- BANNER -->
    <div class="banner__container">
        <img class="banner__background" src="{{ $bannerUrl }}" alt="KANAFEST 2025 Banner Background" />
    </div>

    <!-- ABOUT SECTION -->
    <section class="container about">
        <div class="about__title-container">
            <h2 class="section-title">{{ $content['about_title'] ?? 'KANAGAWA FESTIVALのご紹介' }}</h2>
            <p class="about__text">{!! $content['about_desc'] ?? '' !!}</p>
        </div>

        <div class="about__gallery-container">
            <img class="about__gallery-flower--top" src="{{ asset('assets/images/kanafest-cherry-blossom-1.png') }}" alt="Cherry Blossom" />
            <img class="about__gallery-flower--bottom" src="{{ asset('assets/images/kanafest-cherry-blossom-2.png') }}" alt="Cherry Blossom" />
            <div class="about__gallery-header">
                <h2>{{ $content['gallery_title'] ?? 'KANAGAWA FESTIVAL in HANOI 2024 の様子' }}</h2>
            </div>
            <p class="about__gallery-desc">{{ $content['gallery_desc'] ?? '' }}</p>
            <div class="about__gallery">
                @forelse($gallery as $image)
                    <a class="image__pop" data-gall="gallery01" href="{{ $image->url }}">
                        <img src="{{ $image->url }}" alt="{{ $image->alt_text }}" loading="lazy">
                    </a>
                @empty
                    {{-- Fallback: hiển thị ảnh tĩnh nếu chưa có ảnh trong DB --}}
                    <a class="image__pop" data-gall="gallery01" href="{{ asset('assets/images/gallery-cultural-exchange.png') }}">
                        <img src="{{ asset('assets/images/gallery-cultural-exchange.png') }}" alt="KANAFEST Cultural Exchange Activities">
                    </a>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SOCIAL MEDIA SECTION -->
    <section class="container social">
        <section class="media">
            <div class="media__container">
                <h3 class="media__youtube-title">{{ $ytTitle }}</h3>
                @if($youtube)
                    <iframe class="media__youtube-frame" src="{{ $youtube }}"
                        title="YouTube video player" loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @endif
            </div>
            <div class="media__container">
                <h3 class="media__facebook-title">{{ $fbTitle }}</h3>
                @if($facebook)
                    <iframe class="media__facebook-frame" src="{{ $facebook }}"
                        style="border:none;overflow:hidden" allowfullscreen="true"
                        loading="lazy"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                        title="Kanagawa Festival Official Facebook Post"></iframe>
                @endif
            </div>
        </section>
    </section>

    <!-- COOPERATION SECTION -->
    <section class="container cooperation">
        <div class="cooperation__container">
            <div class="cooperation__sponsors-title-container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title">協力</h2>
                    <ul class="cooperation__organizations">
                        {!! $content['cooperation'] ?? '' !!}
                    </ul>
                </div>
                <div class="cooperation__content">
                    <h2 class="cooperation__title">後援</h2>
                    <ul class="cooperation__organizations">
                        {!! $content['endorsement'] ?? '' !!}
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    new VenoBox({
        selector: '.image__pop',
        numeration: true,
        infinigall: true,
        share: true,
        spinner: 'plane'
    });
</script>
@endpush
