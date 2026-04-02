<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $content  = PageContent::getPage('sponsor');
        $sponsors = Sponsor::active()->get()->groupBy('tier');
        $tiers    = Sponsor::$tierConfig;
        return view('sponsor', compact('content', 'sponsors', 'tiers'));
    }
}
