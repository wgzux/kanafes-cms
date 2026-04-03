@extends('layouts.app')
@section('title', 'KANAGAWA FESTIVAL IN HANOI 2025')

@section('content')
    <section class="about__section">
        <div class="container about__container">
            <h1 class="about__title">{{ $content['page_title'] ?? '会場マップ / 出展者情報' }}</h1>
        </div>
    </section>

    <div class="container about__body">
        <!-- Map Image + Legend -->
        <div class="body__image">
            <div class="body__image-map">
                @if($mapImage)
                    <img src="{{ asset('storage/map/' . $mapImage) }}" alt="Map Kanagawa">
                @else
                    <img src="{{ asset('assets/images/map-kanagawa.png') }}" alt="Map Kanagawa">
                @endif
            </div>
            <div class="image__desc">
                @if($boothGroups->isNotEmpty())
                    @foreach($boothGroups as $groupName => $booths)
                        <div class="color__item">
                            <div class="color__box" style="background-color: {{ $booths->first()->group_color }}"></div>
                            <p class="color__text">{{ $groupName }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="color__item"><div class="color__box"></div><p class="color__text">協賛者</p></div>
                    <div class="color__item"><div class="color__box"></div><p class="color__text">飲食</p></div>
                    <div class="color__item"><div class="color__box"></div><p class="color__text">主催者</p></div>
                    <div class="color__item"><div class="color__box"></div><p class="color__text">物販</p></div>
                    <div class="color__item"><div class="color__box"></div><p class="color__text">ハノイ市ブース</p></div>
                @endif
            </div>
        </div>

        <!-- Booth List — Dynamic from DB -->
        <div class="booth__group">
            @if($boothGroups->isNotEmpty())
                @foreach($boothGroups as $groupName => $booths)
                <div class="booth-container">
                    <h4 class="booth__title" style="color: {{ $booths->first()->group_color }}">{{ $groupName }}</h4>
                    @foreach($booths as $booth)
                    <div class="booth__item">
                        <div class="booth__number" style="background-color: {{ $booth->group_color }}; color: white;">{{ $booth->booth_number }}</div>
                        <p class="booth__desc">{{ $booth->booth_name }}</p>
                    </div>
                    @endforeach
                </div>
                @endforeach
            @else
                {{-- Fallback: danh sách gốc hard-coded --}}
                <div class="booth-container">
                    <h4 class="booth__title">企業ブース</h4>
                    <div class="booth__item"><div class="booth__number">1</div><p class="booth__desc">Da Nang Mikazuki Japanese Resorts &amp; Spa</p></div>
                    <div class="booth__item"><div class="booth__number">2</div><p class="booth__desc">AIDEM Inc.</p></div>
                    <div class="booth__item"><div class="booth__number">4</div><p class="booth__desc">XÂY DỰNG NORITAKE</p></div>
                    <div class="booth__item"><div class="booth__number">5</div><p class="booth__desc">XÂY DỰNG NORITAKE</p></div>
                    <div class="booth__item"><div class="booth__number">6</div><p class="booth__desc">JFE Engineering Corporation</p></div>
                    <div class="booth__item"><div class="booth__number">7</div><p class="booth__desc">Kiraboshi Bank, Ltd.</p></div>
                </div>
                <div class="booth-container">
                    <h4 class="booth__title">主催者ブース</h4>
                    <div class="booth__item"><div class="booth__number">10</div><p class="booth__desc">Tourism Division, Kanagawa Prefectural Government</p></div>
                    <div class="booth__item"><div class="booth__number">11</div><p class="booth__desc">Tourism Division, Kanagawa Prefectural Government</p></div>
                    <div class="booth__item"><div class="booth__number">12</div><p class="booth__desc">Tourism Division, Kanagawa Prefectural Government</p></div>
                    <div class="booth__item"><div class="booth__number">13</div><p class="booth__desc">Tourism Division, Kanagawa Prefectural Government</p></div>
                    <div class="booth__item"><div class="booth__number">14</div><p class="booth__desc">Kanagawa Prefecture・Traditional Crafts</p></div>
                    <div class="booth__item"><div class="booth__number">15</div><p class="booth__desc">TAGGER TRAVEL</p></div>
                    <div class="booth__item"><div class="booth__number">16</div><p class="booth__desc">SONG HAN TOURIST</p></div>
                    <div class="booth__item"><div class="booth__number">17</div><p class="booth__desc">The Japan-Vietnam Association</p></div>
                    <div class="booth__item"><div class="booth__number">18</div><p class="booth__desc">Foundation of Japan - Vietnam Cultural Association</p></div>
                    <div class="booth__item"><div class="booth__number">24</div><p class="booth__desc">漢字＆習字 【HANOI UNIV CCJLC】</p></div>
                    <div class="booth__item"><div class="booth__number">25</div><p class="booth__desc">未病（Mibyo）Blood pressure test</p></div>
                </div>
                <div class="booth-container">
                    <h4 class="booth__title">飲食</h4>
                    <div class="booth__item"><div class="booth__number">3</div><p class="booth__desc">TAKOBAR</p></div>
                    <div class="booth__item"><div class="booth__number">8</div><p class="booth__desc">Little Japan</p></div>
                    <div class="booth__item"><div class="booth__number">9</div><p class="booth__desc">GENYA</p></div>
                    <div class="booth__item"><div class="booth__number">21</div><p class="booth__desc">ĂN VẶT NHÀ CỐM</p></div>
                    <div class="booth__item"><div class="booth__number">22</div><p class="booth__desc">Nhà hàng Dũng Hằng</p></div>
                    <div class="booth__item"><div class="booth__number">23</div><p class="booth__desc">Nhà hàng Dũng Hằng</p></div>
                </div>
                <div class="booth-container">
                    <h4 class="booth__title">物販</h4>
                    <div class="booth__item"><div class="booth__number">19</div><p class="booth__desc">MỌT SÁCH MOGU</p></div>
                    <div class="booth__item"><div class="booth__number">20</div><p class="booth__desc">KEM QUE ĐÁ BÀO GARI GARI KUN</p></div>
                    <div class="booth__item"><div class="booth__number">26</div><p class="booth__desc">HMG POPUP PAPER</p></div>
                    <div class="booth__item"><div class="booth__number">27</div><p class="booth__desc">Play Plus - Board Game Publisher</p></div>
                    <div class="booth__item"><div class="booth__number">28</div><p class="booth__desc">SAKURA SPORTS ACADEMY</p></div>
                </div>
                <div class="booth-container">
                    <h4 class="booth__title">ハノイ市ブース</h4>
                    <div class="booth__item"><div class="booth__number">H1</div><p class="booth__desc">Umami Café</p></div>
                    <div class="booth__item"><div class="booth__number">H2</div><p class="booth__desc">Cốm Phượng Anh</p></div>
                    <div class="booth__item"><div class="booth__number">H3</div><p class="booth__desc">Thức quà Hà Nội</p></div>
                </div>
            @endif
        </div>
    </div>

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
