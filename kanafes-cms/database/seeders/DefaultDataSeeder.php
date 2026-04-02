<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\PageContent;
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        // === SITE SETTINGS ===
        $settings = [
            ['key' => 'banner_image',    'value' => null,                                           'type' => 'image', 'label' => 'Ảnh bìa trang chủ'],
            ['key' => 'youtube_url',     'value' => 'https://www.youtube.com/embed/rrxFe7I1ZuA?si=LCQrbX-nTwEdoK0F', 'type' => 'url', 'label' => 'Link YouTube (embed)'],
            ['key' => 'facebook_post_url','value' => 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fkanagawafestivalinhanoi%2Fposts%2Fpfbid012u3RbuHZeJA292vXe4Dm2BaAgzwLphNacHExUUztRVvgTFvahUo5hVsng8Kj4Ktl%26show_text=false', 'type' => 'url', 'label' => 'Link Facebook Post (embed)'],
            ['key' => 'site_name',       'value' => 'KANAGAWA FESTIVAL IN HANOI 2025',             'type' => 'text', 'label' => 'Tên website'],
            ['key' => 'footer_organizer','value' => 'ハノイ市人民委員会／ベトナムフェスタin神奈川実行委員会',  'type' => 'text', 'label' => 'Nhà tổ chức (Footer)'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // === PAGE CONTENTS ===
        $pages = [
            // HOME
            ['page' => 'home', 'section' => 'about_title',   'type' => 'text', 'label' => 'Tiêu đề giới thiệu',        'value' => 'KANAGAWA FESTIVALのご紹介'],
            ['page' => 'home', 'section' => 'about_desc',    'type' => 'html', 'label' => 'Mô tả giới thiệu',           'value' => 'ハノイのKANAGAWA FESTIVALは、首都ハノイの中心部で毎年11月に開催される毎年恒例のフェスティバルです。神奈川県とハノイの文化を繋ぎ、ベトナムと日本の友好を繋ぐことを目的としています。'],
            ['page' => 'home', 'section' => 'gallery_title', 'type' => 'text', 'label' => 'Tiêu đề thư viện ảnh',       'value' => 'KANAGAWA FESTIVAL in HANOI 2024 の様子'],
            ['page' => 'home', 'section' => 'gallery_desc',  'type' => 'text', 'label' => 'Mô tả thư viện ảnh',         'value' => 'たくさんのご来場ありがとうございました。'],
            ['page' => 'home', 'section' => 'youtube_title', 'type' => 'text', 'label' => 'Tiêu đề YouTube',            'value' => '神奈川県公式YOUTUBEチャンネル'],
            ['page' => 'home', 'section' => 'facebook_title','type' => 'text', 'label' => 'Tiêu đề Facebook',           'value' => '公式FACEBOOK'],
            ['page' => 'home', 'section' => 'cooperation',   'type' => 'html', 'label' => 'Nội dung hợp tác (HTML)',    'value' => "<li>神奈川よさこい組織委員会</li>\n<li>公益社団法人ベトナム協会</li>\n<li>ＮＰＯきもの文化交流協会</li>\n<li>日越友好文化交流(HATO CLUB)</li>\n<li>横濱ハイカラきもの館</li>\n<li>ベトナム•日本学生インターンシップ推進協議会</li>"],
            ['page' => 'home', 'section' => 'endorsement',   'type' => 'html', 'label' => 'Nội dung hậu thuẫn (HTML)', 'value' => "<li>在ベトナム日本国大使館</li>\n<li>ベトナム日本商工会議所</li>\n<li>独立行政法人国際交流基金ベトナム日本文化交流センター</li>\n<li>独立行政法人国際協力機構ベトナム事務所</li>\n<li>独立行政法人日本学生支援機構</li>\n<li>独立行政法人日本政府観光局ハノイ事務所</li>\n<li>独立行政法人日本貿易振興機構ハノイ事務所</li>"],

            // ABOUT
            ['page' => 'about', 'section' => 'page_title',   'type' => 'text', 'label' => 'Tiêu đề trang',         'value' => '開催概要'],
            ['page' => 'about', 'section' => 'body_content', 'type' => 'html', 'label' => 'Nội dung trang (HTML)', 'value' => '<p>開催概要のコンテンツをここに入力してください。</p>'],

            // EVENT
            ['page' => 'event', 'section' => 'page_title',   'type' => 'text', 'label' => 'Tiêu đề trang',         'value' => 'イベント情報'],
            ['page' => 'event', 'section' => 'body_content', 'type' => 'html', 'label' => 'Nội dung trang (HTML)', 'value' => '<p>イベント情報をここに入力してください。</p>'],

            // MAP
            ['page' => 'map', 'section' => 'page_title',   'type' => 'text', 'label' => 'Tiêu đề trang',         'value' => '会場マップ'],
            ['page' => 'map', 'section' => 'body_content', 'type' => 'html', 'label' => 'Nội dung trang (HTML)', 'value' => '<p>会場マップをここに入力してください。</p>'],

            // SPONSOR PAGE
            ['page' => 'sponsor', 'section' => 'page_title',   'type' => 'text', 'label' => 'Tiêu đề trang',         'value' => '協賛企業'],
            ['page' => 'sponsor', 'section' => 'body_content', 'type' => 'html', 'label' => 'Nội dung trang (HTML)', 'value' => '<p>協賛企業情報をここに入力してください。</p>'],
        ];

        foreach ($pages as $content) {
            PageContent::updateOrCreate(
                ['page' => $content['page'], 'section' => $content['section']],
                $content
            );
        }

        $this->command->info('✅ Default site settings and page contents seeded.');
    }
}
