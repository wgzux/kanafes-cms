<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::orderByRaw("FIELD(tier, 'diamond','gold','silver','bronze')")->orderBy('sort_order')->get();
        $tiers = Sponsor::$tierConfig;
        return view('admin.sponsors.index', compact('sponsors', 'tiers'));
    }

    public function create()
    {
        $tiers = Sponsor::$tierConfig;
        return view('admin.sponsors.create', compact('tiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url',
            'tier'        => 'required|in:diamond,gold,silver,bronze',
            'sort_order'  => 'nullable|integer',
        ]);

        $filename = null;
        if ($request->hasFile('logo')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('sponsors', $filename, 'public');
        }

        Sponsor::create([
            'name'        => $request->name,
            'logo'        => $filename,
            'website_url' => $request->website_url,
            'tier'        => $request->tier,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Nhà tài trợ đã được thêm!');
    }

    public function edit(Sponsor $sponsor)
    {
        $tiers = Sponsor::$tierConfig;
        return view('admin.sponsors.edit', compact('sponsor', 'tiers'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url',
            'tier'        => 'required|in:diamond,gold,silver,bronze',
            'sort_order'  => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::disk('public')->delete('sponsors/' . $sponsor->logo);
            }
            $filename = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('sponsors', $filename, 'public');
            $sponsor->logo = $filename;
        }

        $sponsor->update([
            'name'        => $request->name,
            'logo'        => $sponsor->logo,
            'website_url' => $request->website_url,
            'tier'        => $request->tier,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Thông tin nhà tài trợ đã được cập nhật!');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete('sponsors/' . $sponsor->logo);
        }
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Đã xóa nhà tài trợ.');
    }
}
