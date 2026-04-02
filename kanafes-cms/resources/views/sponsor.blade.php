@extends('layouts.app')
@section('title', 'KANAGAWA FESTIVAL IN HANOI 2025')

@section('content')
    <!-- SPONSOR SECTION START -->
    <section class="container sponsor__section">
        <div class="sponsor__title">
            <h2>協賛企業のご紹介</h2>
            <div class="sponsor__title-underline"></div>
        </div>

        {{-- Hiển thị từ DB nếu có, fallback về danh sách gốc --}}
        @if($sponsors->flatten()->isNotEmpty())
            {{-- Sponsors từ Admin CMS --}}
            @foreach(['diamond','gold','silver','bronze'] as $tier)
                @if(isset($sponsors[$tier]) && $sponsors[$tier]->isNotEmpty())
                    @foreach($sponsors[$tier] as $sponsor)
                        @if($sponsor->website_url)
                            <a href="{{ $sponsor->website_url }}" target="_blank" class="sponsor__row">
                                <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}"/>
                                <span>{{ $sponsor->name }}</span>
                            </a>
                        @else
                            <div class="sponsor__row">
                                <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}"/>
                                <span>{{ $sponsor->name }}</span>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @else
            {{-- FALLBACK: Danh sách nhà tài trợ gốc từ HTML tĩnh --}}
            <a href="https://mikazuki.com.vn/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/mikazuki.png') }}" alt="Hotel-Mikazuki"/>
                <span>株式会社ホテル三日月<br/>Hotel Mikazuki</span>
            </a>
            <a href="https://www.vietnamairlines.com/jp/ja/home" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/vietnamairlines.png') }}" alt="Vietnam Airlines"/>
                <span>ベトナム航空 日本支社<br/>Vietnam Airlines</span>
            </a>
            <a href="https://www.nitori.co.jp/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/nitori.png') }}" alt="Nitori"/>
                <span>株式会社ニトリ<br/>NITORI CO.,LTD.</span>
            </a>
            <a href="https://www.smileswallet.com/japan/vi/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/digitalwallet.png') }}" alt="Smiles Digital Wallet"/>
                <span>株式会社デジタルワレット<br/>CHUYỂN TIỀN SMILES</span>
            </a>
            <a href="https://sendmoney.co.jp/jp/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/sendmoney.png') }}" alt="DCOM Send Money"/>
                <span>株式会社ディコミュニケーションズ<br/>DCOM MONEY EXPRESS</span>
            </a>
            <a href="https://noriken.co.jp/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/norihen.png') }}" alt="Noriken"/>
                <span>株式会社則武建設<br/>Noriken</span>
            </a>
            <a href="https://aidemglobal.jp/aitoku/" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/aidem.png') }}" alt="Aidem"/>
                <span>株式会社アイデム<br/>AIDEM Inc.</span>
            </a>
            <div class="sponsor__row sponsor__row--two-item">
                <a href="https://www.nisso.co.jp/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/nisso.png') }}" alt="Nisso"/>
                    <span>日総工産株式会社<br/>NISSO CORPORATION</span>
                </a>
                <a href="https://oicgroup.co.jp/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/oicgroup.png') }}" alt="OIC Group"/>
                    <span>株式会社OICグループ<br/>OIC GROUP CO., LTD.</span>
                </a>
            </div>
            <div class="sponsor__row sponsor__row--half">
                <a href="https://www.jfe-eng.co.jp/en/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/jfe.png') }}" alt="JFE"/>
                    <span>JFEエンジニアリング株式会社<br/>JFE Engineering Corporation</span>
                </a>
            </div>
            <div class="sponsor__row sponsor__row--three-item">
                <a href="https://www.kipc.or.jp/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/kipc.png') }}" alt="KIPC"/>
                    <span>公益財団法人神奈川産業振興センター<br/>Kanagawa Industrial Promotion Center</span>
                </a>
                <a href="https://www.koeitecmo.co.jp/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/koeitecmo.png') }}" alt="Koei Tecmo Games"/>
                    <span>株式会社コーエーテクモホールディングス<br/>KOEI TECMO HOLDINGS CO., LTD.</span>
                </a>
                <a href="https://kiraboshi-bc.com.vn/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/kiraboshibank.png') }}" alt="Kirabo Shibank"/>
                    <span>株式会社きらぼし銀行<br/>KIRABOSHI BUSINESS CONSULTING VIETNAM COMPANY LIMITED.</span>
                </a>
            </div>
            <div class="sponsor__row sponsor__row--three-item">
                <a href="https://www.nissin-tw.com/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/nissin.png') }}" alt="Nissin"/>
                    <span>株式会社日新<br/>NISSIN CORPORATION</span>
                </a>
                <a href="https://nissinvn.com.vn/en/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/nissinvn.png') }}" alt="Nissin Vietnam"/>
                    <span>ベトナム日新<br/>NISSIN LOGISTICS (VN) CO.,LTD.</span>
                </a>
            </div>
            <div class="sponsor__row sponsor__row--half sponsor__row--half-smaller">
                <a href="https://biz-ex.biz/" target="_blank" class="sponsor__column">
                    <img src="{{ asset('assets/images/biz.png') }}" alt="Biz"/>
                    <span>ビゼックス合同事務所<br/>Văn phòng chung Bizex</span>
                </a>
            </div>

            <br><br><br>
            <div class="sponsor__title">
                <h2>協力</h2>
                <div class="sponsor__title-underline"></div>
            </div>
            <a href="https://www.takara-group.net" target="_blank" class="sponsor__row">
                <img src="{{ asset('assets/images/takara.png') }}" alt="Takara"/>
                <span>株式会社タカラ<br>TAKARA</span>
            </a>
        @endif
    </section>
    <!-- SPONSOR SECTION END -->

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
