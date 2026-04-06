<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerCompanyController extends Controller
{
    public function index()
    {
        $partners = PartnerCompany::orderBy('sort_order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:1000',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url',
            'sort_order'  => 'nullable|integer',
        ]);

        $filename = null;
        if ($request->hasFile('logo')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('partners', $filename, 'public');
        }

        PartnerCompany::create([
            'name'        => $request->name,
            'logo'        => $filename,
            'website_url' => $request->website_url,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Công ty đối tác đã được thêm!');
    }

    public function edit(PartnerCompany $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, PartnerCompany $partner)
    {
        $request->validate([
            'name'        => 'required|string|max:1000',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url',
            'sort_order'  => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete('partners/' . $partner->logo);
            }
            $filename = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('partners', $filename, 'public');
            $partner->logo = $filename;
        }

        $partner->update([
            'name'        => $request->name,
            'logo'        => $partner->logo,
            'website_url' => $request->website_url,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Thông tin đối tác đã được cập nhật!');
    }

    public function destroy(PartnerCompany $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete('partners/' . $partner->logo);
        }
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Đã xóa công ty đối tác.');
    }
}
