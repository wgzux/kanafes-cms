<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MapBooth;

class MapBoothSeeder extends Seeder
{
    public function run(): void
    {
        $booths = [
            // 企業ブース (Corporate) — Red
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '1', 'booth_name' => 'Da Nang Mikazuki Japanese Resorts & Spa', 'sort_order' => 1],
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '2', 'booth_name' => 'AIDEM Inc.', 'sort_order' => 2],
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '4', 'booth_name' => 'XÂY DỰNG NORITAKE', 'sort_order' => 3],
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '5', 'booth_name' => 'XÂY DỰNG NORITAKE', 'sort_order' => 4],
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '6', 'booth_name' => 'JFE Engineering Corporation', 'sort_order' => 5],
            ['group_name' => '企業ブース', 'group_color' => '#8B0000', 'booth_number' => '7', 'booth_name' => 'Kiraboshi Bank, Ltd.', 'sort_order' => 6],

            // 主催者ブース (Organizer) — Green
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '10', 'booth_name' => 'Tourism Division, Kanagawa Prefectural Government', 'sort_order' => 1],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '11', 'booth_name' => 'Tourism Division, Kanagawa Prefectural Government', 'sort_order' => 2],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '12', 'booth_name' => 'Tourism Division, Kanagawa Prefectural Government', 'sort_order' => 3],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '13', 'booth_name' => 'Tourism Division, Kanagawa Prefectural Government', 'sort_order' => 4],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '14', 'booth_name' => 'Kanagawa Prefecture・Traditional Crafts', 'sort_order' => 5],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '15', 'booth_name' => 'TAGGER TRAVEL', 'sort_order' => 6],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '16', 'booth_name' => 'SONG HAN TOURIST', 'sort_order' => 7],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '17', 'booth_name' => 'The Japan-Vietnam Association - a Public Interest Incorporated Association -', 'sort_order' => 8],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '18', 'booth_name' => 'Foundation of Japan - Vietnam Cultural Association - Since 1992 -', 'sort_order' => 9],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '24', 'booth_name' => '漢字＆習字 【HANOI UNIV CCJLC】', 'sort_order' => 10],
            ['group_name' => '主催者ブース', 'group_color' => '#006400', 'booth_number' => '25', 'booth_name' => '未病（Mibyo）Blood pressure test & green juice tasting / 東京リブロヘルスケア', 'sort_order' => 11],

            // 飲食 (Food) — Blue
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '3', 'booth_name' => 'TAKOBAR', 'sort_order' => 1],
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '8', 'booth_name' => 'Little Japan', 'sort_order' => 2],
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '9', 'booth_name' => 'GENYA', 'sort_order' => 3],
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '21', 'booth_name' => 'ĂN VẶT NHÀ CỐM', 'sort_order' => 4],
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '22', 'booth_name' => 'Nhà hàng Dũng Hằng', 'sort_order' => 5],
            ['group_name' => '飲食', 'group_color' => '#4682B4', 'booth_number' => '23', 'booth_name' => 'Nhà hàng Dũng Hằng', 'sort_order' => 6],

            // 物販 (Retail) — Yellow
            ['group_name' => '物販', 'group_color' => '#DAA520', 'booth_number' => '19', 'booth_name' => 'MỌT SÁCH MOGU', 'sort_order' => 1],
            ['group_name' => '物販', 'group_color' => '#DAA520', 'booth_number' => '20', 'booth_name' => 'KEM QUE ĐÁ BÀO GARI GARI KUN', 'sort_order' => 2],
            ['group_name' => '物販', 'group_color' => '#DAA520', 'booth_number' => '26', 'booth_name' => 'HMG POPUP PAPER', 'sort_order' => 3],
            ['group_name' => '物販', 'group_color' => '#DAA520', 'booth_number' => '27', 'booth_name' => 'Play Plus - Board Game Publisher', 'sort_order' => 4],
            ['group_name' => '物販', 'group_color' => '#DAA520', 'booth_number' => '28', 'booth_name' => 'SAKURA SPORTS ACADEMY', 'sort_order' => 5],

            // ハノイ市ブース (Hanoi City) — Orange
            ['group_name' => 'ハノイ市ブース', 'group_color' => '#FF6347', 'booth_number' => 'H1', 'booth_name' => 'Umami Café', 'sort_order' => 1],
            ['group_name' => 'ハノイ市ブース', 'group_color' => '#FF6347', 'booth_number' => 'H2', 'booth_name' => 'Cốm Phượng Anh', 'sort_order' => 2],
            ['group_name' => 'ハノイ市ブース', 'group_color' => '#FF6347', 'booth_number' => 'H3', 'booth_name' => 'Thức quà Hà Nội', 'sort_order' => 3],
        ];

        foreach ($booths as $b) {
            MapBooth::create($b);
        }
    }
}
