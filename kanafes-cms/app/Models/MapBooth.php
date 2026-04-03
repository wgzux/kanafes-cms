<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapBooth extends Model
{
    protected $fillable = ['group_name', 'group_color', 'booth_number', 'booth_name', 'sort_order'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('group_name')->orderBy('sort_order');
    }

    /**
     * Lấy danh sách unique group names với color
     */
    public static function getGroups()
    {
        return static::select('group_name', 'group_color')
            ->distinct()
            ->orderBy('group_name')
            ->get()
            ->unique('group_name');
    }
}
