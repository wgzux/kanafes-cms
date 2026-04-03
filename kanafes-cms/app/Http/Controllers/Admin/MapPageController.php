<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapBooth;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapPageController extends Controller
{
    public function index()
    {
        $mapImage = SiteSetting::get('map_image');
        $groups = MapBooth::select('group_name', 'group_color')
            ->distinct()->get()->unique('group_name');
        $booths = MapBooth::orderBy('group_name')->orderBy('sort_order')->get()->groupBy('group_name');

        return view('admin.map-page.index', compact('mapImage', 'groups', 'booths'));
    }

    public function updateMap(Request $request)
    {
        $request->validate([
            'map_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('map_image')) {
            $old = SiteSetting::get('map_image');
            if ($old) Storage::disk('public')->delete('map/' . $old);
            $fn = 'map_' . time() . '.' . $request->file('map_image')->getClientOriginalExtension();
            $request->file('map_image')->storeAs('map', $fn, 'public');
            SiteSetting::set('map_image', $fn);
        }

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Bản đồ đã được cập nhật!');
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'group_name'  => 'required|string|max:255',
            'group_color' => 'required|string|max:7',
        ]);

        // Tạo 1 booth placeholder để nhóm hiện ra
        MapBooth::create([
            'group_name'   => $request->group_name,
            'group_color'  => $request->group_color,
            'booth_number' => '1',
            'booth_name'   => 'Gian hàng mới',
            'sort_order'   => 1,
        ]);

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã tạo nhóm "' . $request->group_name . '"!');
    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'old_group_name' => 'required|string',
            'group_name'     => 'required|string|max:255',
            'group_color'    => 'required|string|max:7',
        ]);

        MapBooth::where('group_name', $request->old_group_name)->update([
            'group_name'  => $request->group_name,
            'group_color' => $request->group_color,
        ]);

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã cập nhật nhóm!');
    }

    public function destroyGroup(Request $request)
    {
        $request->validate(['group_name' => 'required|string']);
        MapBooth::where('group_name', $request->group_name)->delete();

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã xóa nhóm và tất cả gian hàng bên trong!');
    }

    public function storeBooth(Request $request)
    {
        $request->validate([
            'group_name'   => 'required|string',
            'booth_number' => 'required|string|max:10',
            'booth_name'   => 'required|string|max:255',
        ]);

        // Lấy color từ group hiện có
        $existing = MapBooth::where('group_name', $request->group_name)->first();
        $color = $existing ? $existing->group_color : '#8B0000';

        $maxOrder = MapBooth::where('group_name', $request->group_name)->max('sort_order') ?? 0;

        MapBooth::create([
            'group_name'   => $request->group_name,
            'group_color'  => $color,
            'booth_number' => $request->booth_number,
            'booth_name'   => $request->booth_name,
            'sort_order'   => $maxOrder + 1,
        ]);

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã thêm gian hàng!');
    }

    public function updateBooth(Request $request, MapBooth $booth)
    {
        $request->validate([
            'booth_number' => 'required|string|max:10',
            'booth_name'   => 'required|string|max:255',
        ]);

        $booth->update($request->only(['booth_number', 'booth_name']));

        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã cập nhật gian hàng!');
    }

    public function destroyBooth(MapBooth $booth)
    {
        $booth->delete();
        return redirect()->route('admin.map-page.index')
            ->with('success', 'Đã xóa gian hàng!');
    }
}
