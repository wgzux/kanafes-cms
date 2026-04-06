<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\PartnerCompany;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $content  = PageContent::getPage('sponsor');
        $sponsors = Sponsor::active()->get()->groupBy('tier');
        $tiers    = Sponsor::$tierConfig;
        $partners = PartnerCompany::active()->get();
        return view('sponsor', compact('content', 'sponsors', 'tiers', 'partners'));
    }
}

