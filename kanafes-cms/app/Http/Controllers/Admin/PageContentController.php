<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    // Danh sách trang và sections có thể quản lý
    private array $pages = [
        'home'    => 'Trang chủ',
        'about'   => 'Giới thiệu',
        'event'   => 'Sự kiện',
        'map'     => 'Bản đồ',
        'sponsor' => 'Nhà tài trợ',
    ];

    public function index()
    {
        $pages = $this->pages;
        return view('admin.page-contents.index', compact('pages'));
    }

    public function edit(string $page)
    {
        if (!array_key_exists($page, $this->pages)) {
            abort(404);
        }

        $contents = PageContent::where('page', $page)->get()->keyBy('section');
        $pageName = $this->pages[$page];

        return view('admin.page-contents.edit', compact('page', 'contents', 'pageName'));
    }

    public function update(Request $request, string $page)
    {
        if (!array_key_exists($page, $this->pages)) {
            abort(404);
        }

        $data = $request->except(['_token', '_method']);

        foreach ($data as $section => $value) {
            PageContent::updateOrCreate(
                ['page' => $page, 'section' => $section],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.page-contents.edit', $page)
            ->with('success', 'Nội dung trang "' . $this->pages[$page] . '" đã được lưu!');
    }
}
