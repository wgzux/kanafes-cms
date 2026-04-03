<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('about');
        $venueImage1 = SiteSetting::get('about_venue_image_1');
        $venueImage2 = SiteSetting::get('about_venue_image_2');
        return view('admin.about-page.index', compact('content', 'venueImage1', 'venueImage2'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'page_title'   => 'nullable|string|max:255',
            'event_date'   => 'nullable|string|max:255',
            'event_time'   => 'nullable|string|max:255',
            'event_venue'  => 'nullable|string|max:1000',
            'venue_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'venue_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Lưu text content
        $textFields = ['page_title', 'event_date', 'event_time', 'event_venue'];
        foreach ($textFields as $field) {
            if ($request->has($field)) {
                PageContent::updateOrCreate(
                    ['page' => 'about', 'section' => $field],
                    ['value' => $request->$field, 'type' => 'text', 'label' => $field]
                );
            }
        }

        // Upload venue images
        if ($request->hasFile('venue_image_1')) {
            $old = SiteSetting::get('about_venue_image_1');
            if ($old) Storage::disk('public')->delete('about/' . $old);
            $filename = 'venue1_' . time() . '.' . $request->file('venue_image_1')->getClientOriginalExtension();
            $request->file('venue_image_1')->storeAs('about', $filename, 'public');
            SiteSetting::set('about_venue_image_1', $filename);
        }

        if ($request->hasFile('venue_image_2')) {
            $old = SiteSetting::get('about_venue_image_2');
            if ($old) Storage::disk('public')->delete('about/' . $old);
            $filename = 'venue2_' . time() . '.' . $request->file('venue_image_2')->getClientOriginalExtension();
            $request->file('venue_image_2')->storeAs('about', $filename, 'public');
            SiteSetting::set('about_venue_image_2', $filename);
        }

        return redirect()->route('admin.about-page.index')
            ->with('success', 'Thông tin trang Tổng quan đã được lưu!');
    }
}
