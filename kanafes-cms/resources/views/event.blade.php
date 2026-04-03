@extends('layouts.app')
@section('title', 'KANAGAWA FESTIVAL IN HANOI 2025')

@section('content')
    <section class="event__section">
        <div class="container event__container">
            <h1 class="event__title">{{ $content['page_title'] ?? 'イベント情報' }}</h1>
            <div class="sponsor__title-underline"></div>
            <p class="event__description">
                {!! $content['event_description'] ?? '2025 年ハノイのKANAGAWA FESTIVALのステージでは、ベトナムと日本のアーティスト グループによる特別なパフォーマンスをお届けします。<br>Sân khấu của Lễ hội Kanagawa Hà Nội 2025 sẽ có màn trình diễn đặc biệt của nhóm nghệ sĩ Việt Nam và Nhật Bản.' !!}
            </p>
            <div class="event__calendar">
                <div>
                    @if($calendarImage1)
                        <img src="{{ asset('storage/event/' . $calendarImage1) }}" alt="Event Calendar Saturday 2025">
                    @else
                        <img src="{{ asset('assets/images/event-calendar-1.jpg') }}" alt="Event Calendar Saturday 2025">
                    @endif
                </div>
                <div>
                    @if($calendarImage2)
                        <img src="{{ asset('storage/event/' . $calendarImage2) }}" alt="Event Calendar Sunday 2025">
                    @else
                        <img src="{{ asset('assets/images/event-calendar-2.jpg') }}" alt="Event Calendar Sunday 2025">
                    @endif
                </div>
            </div>
        </div>

        <div class="container event__body">
            {{-- AMBASSADORS --}}
            @if($ambassadors->isNotEmpty())
                @foreach($ambassadors as $performer)
                <div class="event__body-content">
                    <h2 class="content__title">アンバサダー</h2>
                    <div class="content__body">
                        @if($performer->image)
                            <img src="{{ $performer->image_url }}" alt="{{ $performer->name }}">
                        @else
                            <img src="{{ asset('assets/images/kolme.png') }}" alt="{{ $performer->name }}">
                        @endif
                        <div class="content__body-text">
                            <h3>{{ $performer->name }}</h3>
                            <p>{!! nl2br(e($performer->description)) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Fallback --}}
                <div class="event__body-content">
                    <h2 class="content__title">アンバサダー</h2>
                    <div class="content__body">
                        <img src="{{ asset('assets/images/kolme.png') }}" alt="Kolme">
                        <div class="content__body-text">
                            <h3>kolme</h3>
                            <p>
                                Avex traxガールズアイドルグループ「kolme」がアンバサダーに就任！<br>
                                会場が一体感に包まれる曲を今年も披露します！<br><br>
                                Nhóm idol nữ "kolme" trực thuộc Avex Trax chính thức trở thành đại sứ của lễ hội!
                                Năm nay, họ sẽ tiếp tục khuấy động sân khấu với những ca khúc bùng nổ khiến cả hội trường hòa làm một!
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SUPPORTERS --}}
            @if($supporters->isNotEmpty())
                <div class="event__body-content">
                    <h2 class="content__title">スペシャルサポーター</h2>
                    @if(isset($content['supporter_intro']) && $content['supporter_intro'])
                        <p class="content__description">{!! $content['supporter_intro'] !!}</p>
                    @else
                        <p class="content__description">
                            スペシャルサポーターに、城崎桃華とLYLYが就任！<br>
                            KANAGAWA FESTIVAL in HANOI 2025のライブステージを盛り上げます！<br>
                            Hai nghệ sĩ hàng đầu - Shirosaki Momoka và LYLY - chính thức trở thành Special Supporter!<br>
                            Cùng nhau họ sẽ thổi bùng không khí sân khấu live của KANAGAWA FESTIVAL in HANOI 2025!
                        </p>
                    @endif
                    <div class="content__body">
                        @foreach($supporters as $supporter)
                        <div class="content__body-half">
                            @if($supporter->image)
                                <img src="{{ $supporter->image_url }}" alt="{{ $supporter->name }}">
                            @else
                                <img src="{{ asset('assets/images/' . ($loop->first ? 'shirosaki.png' : 'ly-ly.png')) }}" alt="{{ $supporter->name }}">
                            @endif
                            <div class="content__body-text">
                                <h3>{{ $supporter->name }}</h3>
                                <p>{!! nl2br(e($supporter->description)) !!}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Fallback --}}
                <div class="event__body-content">
                    <h2 class="content__title">スペシャルサポーター</h2>
                    <p class="content__description">
                        スペシャルサポーターに、城崎桃華とLYLYが就任！<br>
                        KANAGAWA FESTIVAL in HANOI 2025のライブステージを盛り上げます！<br>
                        Hai nghệ sĩ hàng đầu - Shirosaki Momoka và LYLY - chính thức trở thành Special Supporter!<br>
                        Cùng nhau họ sẽ thổi bùng không khí sân khấu live của KANAGAWA FESTIVAL in HANOI 2025!
                    </p>
                    <div class="content__body">
                        <div class="content__body-half">
                            <img src="{{ asset('assets/images/shirosaki.png') }}" alt="Shirosaki Momoka">
                            <div class="content__body-text">
                                <h3>城崎桃華</h3>
                                <p>アニソンシンガー兼声優の城崎桃華が、ベトナムの若者も知っている日本の有名なアニソン曲を歌唱します。<br>Shirosaki Momoka, vừa là ca sĩ nhạc anime vừa là diễn viên lồng tiếng, sẽ trình diễn những ca khúc anime nổi tiếng của Nhật Bản mà giới trẻ Việt Nam đã quen thuộc.</p>
                            </div>
                        </div>
                        <div class="content__body-half">
                            <img src="{{ asset('assets/images/ly-ly.png') }}" alt="LYLY">
                            <div class="content__body-text">
                                <h3>LYLY</h3>
                                <p>ベトナム音楽界で多彩な才能と優れた業績を誇るLYLYがスペシャルライブを披露。<br>Nữ nghệ sĩ đa tài với loạt thành tích âm nhạc nổi bật trong làng nhạc Việt Nam - LYLY sẽ có một buổi biểu diễn đặc biệt tại Lễ hội.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- GUESTS --}}
            @if($guests->isNotEmpty())
                @foreach($guests as $guest)
                <div class="event__body-content">
                    <h2 class="content__title">スペシャルゲスト</h2>
                    <div class="content__body">
                        @if($guest->image)
                            <img src="{{ $guest->image_url }}" alt="{{ $guest->name }}">
                        @else
                            <img src="{{ asset('assets/images/hoang-dung.png') }}" alt="{{ $guest->name }}">
                        @endif
                        <div class="content__body-text">
                            <h3>{{ $guest->name }}</h3>
                            <p>{!! nl2br(e($guest->description)) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Fallback --}}
                <div class="event__body-content">
                    <h2 class="content__title">スペシャルゲスト</h2>
                    <div class="content__body">
                        <img src="{{ asset('assets/images/hoang-dung.png') }}" alt="Hoang Dung">
                        <div class="content__body-text">
                            <h3>Hoàng Dũng</h3>
                            <p>スペシャルゲストに、繊細で洗練された歌声と豊かな表現力が魅力のHoàng Dũng（ホアン・ズン）が登場！<br>Với giọng hát tinh tế và đầy cảm xúc, Hoàng Dũng - ca sĩ kiêm nhạc sĩ nổi tiếng - được yêu thích qua các bản hit như "Nàng Thơ".</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- COOPERATION SECTION -->
    <section class="container cooperation">
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
