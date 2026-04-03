<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventPerformer extends Model
{
    protected $fillable = ['category', 'name', 'description', 'image', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static array $categoryConfig = [
        'ambassador' => ['label' => 'アンバサダー (Đại sứ)', 'label_short' => 'Đại sứ'],
        'supporter'  => ['label' => 'スペシャルサポーター (Người ủng hộ)', 'label_short' => 'Người ủng hộ đặc biệt'],
        'guest'      => ['label' => 'スペシャルゲスト (Khách mời)', 'label_short' => 'Khách mời đặc biệt'],
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists('performers/' . $this->image)) {
            return asset('storage/performers/' . $this->image);
        }
        return asset('assets/images/placeholder.png');
    }
}
