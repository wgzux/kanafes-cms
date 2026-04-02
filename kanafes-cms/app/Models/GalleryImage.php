<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'filename', 'alt_text', 'caption', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: chỉ lấy ảnh đang active, sắp xếp theo sort_order
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Trả về URL đầy đủ của ảnh từ storage
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/gallery/' . $this->filename);
    }
}
