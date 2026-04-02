<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name', 'logo', 'website_url', 'tier', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Cấu hình kích thước logo theo cấp bậc (dùng trong Blade)
    public static array $tierConfig = [
        'diamond' => [
            'label'      => 'Kim cương',
            'color'      => 'bg-cyan-100 text-cyan-800',
            'logo_class' => 'h-28',
            'order'      => 1,
        ],
        'gold'    => [
            'label'      => 'Vàng',
            'color'      => 'bg-yellow-100 text-yellow-800',
            'logo_class' => 'h-20',
            'order'      => 2,
        ],
        'silver'  => [
            'label'      => 'Bạc',
            'color'      => 'bg-gray-100 text-gray-700',
            'logo_class' => 'h-14',
            'order'      => 3,
        ],
        'bronze'  => [
            'label'      => 'Đồng',
            'color'      => 'bg-orange-100 text-orange-800',
            'logo_class' => 'h-10',
            'order'      => 4,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderByRaw("FIELD(tier, 'diamond','gold','silver','bronze')")->orderBy('sort_order');
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/sponsors/' . $this->logo);
        }
        return asset('assets/images/sponsor-placeholder.png');
    }

    public function getTierLabelAttribute(): string
    {
        return static::$tierConfig[$this->tier]['label'] ?? $this->tier;
    }

    public function getTierColorAttribute(): string
    {
        return static::$tierConfig[$this->tier]['color'] ?? 'bg-gray-100';
    }

    public function getLogoClassAttribute(): string
    {
        return static::$tierConfig[$this->tier]['logo_class'] ?? 'h-12';
    }
}
