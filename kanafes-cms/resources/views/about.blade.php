@extends('layouts.app')
@section('title', 'KANAGAWA FESTIVAL IN HANOI 2025')

@section('content')
    <!-- MAP HERO SECTION -->
    <section class="map-hero">
        <div class="container map-hero__container">
            <h1 class="map-hero__title">{{ $content['page_title'] ?? '開催概要' }}</h1>
        </div>
    </section>

    <!-- EVENT DETAILS SECTION -->
    <section class="container event-details">
        <div class="event-details__container">
            <div class="event-info">
                <div class="event-info__item">
                    <ul class="event-info__label">
                        <li>開催日程</li>
                    </ul>
                    <div class="event-info__value">{{ $content['event_date'] ?? '2025.11.15(土), 16(日)' }}</div>
                </div>
                <div class="event-info__item">
                    <ul class="event-info__label">
                        <li>時間</li>
                    </ul>
                    <div class="event-info__value">{{ $content['event_time'] ?? '11:00～21:00' }}</div>
                </div>
                <div class="event-info__item">
                    <ul class="event-info__label">
                        <li>会場</li>
                    </ul>
                    <div class="event-info__value">
                        {!! $content['event_venue'] ?? '統一公園前広場、チャン・ニャン・トン通り<br/>Khu vực trước cổng công viên Thống Nhất, phố Trần Nhân Tông' !!}
                    </div>
                </div>
            </div>

            <!-- Venue Gallery — Dynamic from DB -->
            <div class="venue-gallery">
                @if($venueImage1)
                    <img src="{{ asset('storage/about/' . $venueImage1) }}" alt="Thong Nhat Park Gate">
                @else
                    <img src="{{ asset('assets/images/map-park.jpg') }}" alt="Thong Nhat Park Gate">
                @endif

                @if($venueImage2)
                    <img src="{{ asset('storage/about/' . $venueImage2) }}" alt="Map to Thong Nhat Park">
                @else
                    <img src="{{ asset('assets/images/map.png') }}" alt="Map to Thong Nhat Park">
                @endif
            </div>
        </div>
    </section>

    <!-- MAP SECTION -->
    <section class="container map-section"></section>

    <!-- COOPERATION SECTION -->
    <section class="container container cooperation">
        <div class="cooperation__container">
            <div class="cooperation__sponsors-title-container">
                <div class="cooperation__content">
                    <h2 class="cooperation__title">協力</h2>
                    <ul class="cooperation__organizations">
                        {!! $content['cooperation'] ?? '
                        <li>神奈川よさこい組織委員会</li>
                        <li>公益社団法人ベトナム協会</li>
                        <li>ＮＰＯきもの文化交流協会</li>
                        <li>日越友好文化交流(HATO CLUB)</li>
                        <li>横濱ハイカラきもの館</li>
                        <li>ベトナム•日本学生インターンシップ推進協議会</li>' !!}
                    </ul>
                </div>
                <div class="cooperation__content">
                    <h2 class="cooperation__title">後援</h2>
                    <ul class="cooperation__organizations">
                        {!! $content['endorsement'] ?? '
                        <li>在ベトナム日本国大使館</li>
                        <li>ベトナム日本商工会議所</li>
                        <li>独立行政法人国際交流基金ベトナム日本文化交流センター</li>
                        <li>独立行政法人国際協力機構ベトナム事務所</li>
                        <li>独立行政法人日本学生支援機構</li>
                        <li>独立行政法人日本政府観光局ハノイ事務所</li>
                        <li>独立行政法人日本貿易振興機構ハノイ事務所</li>' !!}
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
