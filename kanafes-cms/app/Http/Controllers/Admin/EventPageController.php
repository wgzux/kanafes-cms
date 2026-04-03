<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventPerformer;
use App\Models\PageContent;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventPageController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('event');
        $calendarImage1 = SiteSetting::get('event_calendar_image_1');
        $calendarImage2 = SiteSetting::get('event_calendar_image_2');

        $ambassadors = EventPerformer::byCategory('ambassador')->get();
        $supporters  = EventPerformer::byCategory('supporter')->get();
        $guests      = EventPerformer::byCategory('guest')->get();
        $categories  = EventPerformer::$categoryConfig;

        return view('admin.event-page.index', compact(
            'content', 'calendarImage1', 'calendarImage2',
            'ambassadors', 'supporters', 'guests', 'categories'
        ));
    }

    public function updateContent(Request $request)
    {
        $request->validate([
            'page_title'        => 'nullable|string|max:255',
            'event_description' => 'nullable|string|max:5000',
            'supporter_intro'   => 'nullable|string|max:5000',
            'calendar_image_1'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'calendar_image_2'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Lưu text
        foreach (['page_title', 'event_description', 'supporter_intro'] as $field) {
            if ($request->has($field)) {
                PageContent::updateOrCreate(
                    ['page' => 'event', 'section' => $field],
                    ['value' => $request->$field, 'type' => 'text']
                );
            }
        }

        // Upload calendar images
        if ($request->hasFile('calendar_image_1')) {
            $old = SiteSetting::get('event_calendar_image_1');
            if ($old) Storage::disk('public')->delete('event/' . $old);
            $fn = 'cal1_' . time() . '.' . $request->file('calendar_image_1')->getClientOriginalExtension();
            $request->file('calendar_image_1')->storeAs('event', $fn, 'public');
            SiteSetting::set('event_calendar_image_1', $fn);
        }

        if ($request->hasFile('calendar_image_2')) {
            $old = SiteSetting::get('event_calendar_image_2');
            if ($old) Storage::disk('public')->delete('event/' . $old);
            $fn = 'cal2_' . time() . '.' . $request->file('calendar_image_2')->getClientOriginalExtension();
            $request->file('calendar_image_2')->storeAs('event', $fn, 'public');
            SiteSetting::set('event_calendar_image_2', $fn);
        }

        return redirect()->route('admin.event-page.index')
            ->with('success', 'Nội dung trang Sự kiện đã được cập nhật!');
    }

    public function storePerformer(Request $request)
    {
        $request->validate([
            'category'    => 'required|in:ambassador,supporter,guest',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['category', 'name', 'description']);
        $data['sort_order'] = EventPerformer::where('category', $request->category)->max('sort_order') + 1;

        if ($request->hasFile('image')) {
            $fn = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('performers', $fn, 'public');
            $data['image'] = $fn;
        }

        EventPerformer::create($data);

        return redirect()->route('admin.event-page.index')
            ->with('success', 'Đã thêm nghệ sĩ mới!');
    }

    public function updatePerformer(Request $request, EventPerformer $performer)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            if ($performer->image) {
                Storage::disk('public')->delete('performers/' . $performer->image);
            }
            $fn = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('performers', $fn, 'public');
            $data['image'] = $fn;
        }

        $performer->update($data);

        return redirect()->route('admin.event-page.index')
            ->with('success', 'Đã cập nhật thông tin nghệ sĩ!');
    }

    public function destroyPerformer(EventPerformer $performer)
    {
        if ($performer->image) {
            Storage::disk('public')->delete('performers/' . $performer->image);
        }
        $performer->delete();

        return redirect()->route('admin.event-page.index')
            ->with('success', 'Đã xóa nghệ sĩ!');
    }
}
