<?php

namespace App\Http\Controllers;

use App\Models\PageContent;

class AboutController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('about');
        return view('about', compact('content'));
    }
}
