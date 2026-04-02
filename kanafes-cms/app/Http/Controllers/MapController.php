<?php

namespace App\Http\Controllers;

use App\Models\PageContent;

class MapController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('map');
        return view('map', compact('content'));
    }
}
