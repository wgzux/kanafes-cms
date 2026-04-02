<?php

namespace App\Http\Controllers;

use App\Models\PageContent;

class EventController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('event');
        return view('event', compact('content'));
    }
}
