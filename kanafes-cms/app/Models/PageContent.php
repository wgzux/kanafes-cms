<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['page', 'section', 'type', 'value', 'label'];

    /**
     * Lấy nội dung một section của một trang cụ thể.
     * Ví dụ: PageContent::getContent('about', 'hero_title')
     */
    public static function getContent(string $page, string $section, string $default = ''): string
    {
        $content = static::where('page', $page)->where('section', $section)->first();
        return $content ? ($content->value ?? $default) : $default;
    }

    /**
     * Lấy tất cả nội dung của một trang dưới dạng mảng key-value.
     * Ví dụ: PageContent::getPage('about') → ['hero_title' => '...', 'body_content' => '...']
     */
    public static function getPage(string $page): array
    {
        return static::where('page', $page)
            ->pluck('value', 'section')
            ->toArray();
    }
}
