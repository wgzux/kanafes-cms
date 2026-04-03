<?php

namespace App\Http\Controllers;

use App\Models\EventPerformer;
use App\Models\PageContent;
use App\Models\SiteSetting;

class EventController extends Controller
{
    public function index()
    {
        $content = PageContent::getPage('event');
        $calendarImage1 = SiteSetting::get('event_calendar_image_1');
        $calendarImage2 = SiteSetting::get('event_calendar_image_2');

        $ambassadors = EventPerformer::active()->byCategory('ambassador')->get();
        $supporters  = EventPerformer::active()->byCategory('supporter')->get();
        $guests      = EventPerformer::active()->byCategory('guest')->get();

        return view('event', compact('content', 'calendarImage1', 'calendarImage2', 'ambassadors', 'supporters', 'guests'));
    }
}
