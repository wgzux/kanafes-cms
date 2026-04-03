<?php

namespace App\Http\Controllers;

use App\Models\MapBooth;
use App\Models\PageContent;
use App\Models\SiteSetting;

class MapController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('map');
        $mapImage = SiteSetting::get('map_image');
        $boothGroups = MapBooth::orderBy('group_name')->orderBy('sort_order')->get()->groupBy('group_name');

        return view('map', compact('content', 'mapImage', 'boothGroups'));
    }
}
