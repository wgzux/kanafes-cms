<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventPerformer;

class EventPerformerSeeder extends Seeder
{
    public function run(): void
    {
        $performers = [
            [
                'category' => 'ambassador',
                'name' => 'kolme',
                'description' => "Avex traxガールズアイドルグループ「kolme」がアンバサダーに就任！\n会場が一体感に包まれる曲を今年も披露します！\n\nNhóm idol nữ \"kolme\" trực thuộc Avex Trax chính thức trở thành đại sứ của lễ hội! Năm nay, họ sẽ tiếp tục khuấy động sân khấu với những ca khúc bùng nổ khiến cả hội trường hòa làm một!",
                'image' => null,
                'sort_order' => 1,
            ],
            [
                'category' => 'supporter',
                'name' => '城崎桃華',
                'description' => "アニソンシンガー兼声優の城崎桃華が、ベトナムの若者も知っている日本の有名なアニソン曲を歌唱します。\nShirosaki Momoka, vừa là ca sĩ nhạc anime vừa là diễn viên lồng tiếng, sẽ trình diễn những ca khúc anime nổi tiếng của Nhật Bản mà giới trẻ Việt Nam đã quen thuộc.",
                'image' => null,
                'sort_order' => 1,
            ],
            [
                'category' => 'supporter',
                'name' => 'LYLY',
                'description' => "ベトナム音楽界で多彩な才能と優れた業績を誇るLYLYがスペシャルライブを披露。\nNữ nghệ sĩ đa tài với loạt thành tích âm nhạc nổi bật trong làng nhạc Việt Nam - LYLY sẽ có một buổi biểu diễn đặc biệt tại Lễ hội.",
                'image' => null,
                'sort_order' => 2,
            ],
            [
                'category' => 'guest',
                'name' => 'Hoàng Dũng',
                'description' => "スペシャルゲストに、繊細で洗練された歌声と豊かな表現力が魅力のHoàng Dũng（ホアン・ズン）が登場！代表曲「Nàng Thơ」（ナン・トー）などで幅広い世代に支持され、国際的なコラボも話題の人気シンガーソングライター。貴重なライブをぜひご覧ください!\nVới giọng hát tinh tế và đầy cảm xúc, Hoàng Dũng - ca sĩ kiêm nhạc sĩ nổi tiếng - được yêu thích qua các bản hit như \"Nàng Thơ\" và những màn kết hợp quốc tế ấn tượng. Đừng bỏ lỡ cơ hội thưởng thức live show đặc biệt này!",
                'image' => null,
                'sort_order' => 1,
            ],
        ];

        foreach ($performers as $p) {
            EventPerformer::create($p);
        }
    }
}
