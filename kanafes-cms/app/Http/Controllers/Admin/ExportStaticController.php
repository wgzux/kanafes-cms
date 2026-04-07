<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventPerformer;
use App\Models\GalleryImage;
use App\Models\MapBooth;
use App\Models\MediaItem;
use App\Models\PageContent;
use App\Models\PartnerCompany;
use App\Models\SiteSetting;
use App\Models\Sponsor;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ExportStaticController extends Controller
{
    /**
     * Base URL used inside the running app (e.g. http://localhost:8000)
     * Everything pointing to this will be rewritten to relative paths.
     */
    private string $appUrl;

    /**
     * Map of internal route → output file name
     */
    private array $pageMap = [
        'index.html'   => 'home',
        'about.html'   => 'about',
        'event.html'   => 'event',
        'map.html'     => 'map',
        'sponsor.html' => 'sponsor',
    ];

    public function export()
    {
        // Increase limits – rendering 5 pages + copying assets can take time
        set_time_limit(300);
        ini_set('memory_limit', '256M');

        $this->appUrl = rtrim(config('app.url'), '/');
        $exportPath   = storage_path('app/export_static_' . time());

        try {
            File::makeDirectory($exportPath, 0755, true);

            // ── 1. Render each public page ─────────────────────────────
            foreach ($this->pageMap as $fileName => $page) {
                $html = $this->renderPage($page);
                $html = $this->rewritePathsForOffline($html, $fileName);
                File::put($exportPath . '/' . $fileName, $html);
            }

            // ── 2. Copy static assets from public/assets/ ──────────────
            if (File::isDirectory(public_path('assets'))) {
                File::copyDirectory(public_path('assets'), $exportPath . '/assets');
            }

            // ── 3. Copy uploaded storage files (banners, sponsor logos…) ─
            $storageLinkPath = public_path('storage');
            if (File::isDirectory($storageLinkPath)) {
                File::copyDirectory($storageLinkPath, $exportPath . '/storage');
            } elseif (File::isDirectory(storage_path('app/public'))) {
                File::copyDirectory(storage_path('app/public'), $exportPath . '/storage');
            }

            // ── 4. Copy favicon ────────────────────────────────────────
            if (File::exists(public_path('favicon.ico'))) {
                File::copy(public_path('favicon.ico'), $exportPath . '/favicon.ico');
            }

            // ── 5. Pack into ZIP ───────────────────────────────────────
            $zipPath = storage_path('app/Kanagawa-LandingPage.zip');
            $this->createZip($exportPath, $zipPath);

        } finally {
            // Always clean up temp folder
            if (File::isDirectory($exportPath)) {
                File::deleteDirectory($exportPath);
            }
        }

        return response()->download($zipPath, 'Kanagawa-LandingPage.zip', [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    // ──────────────────────────────────────────────────────────────────────
    // Private helpers
    // ──────────────────────────────────────────────────────────────────────

    private function renderPage(string $page): string
    {
        return match ($page) {
            'home'    => $this->renderHome(),
            'about'   => $this->renderAbout(),
            'event'   => $this->renderEvent(),
            'map'     => $this->renderMap(),
            'sponsor' => $this->renderSponsor(),
            default   => '',
        };
    }

    private function renderHome(): string
    {
        $banner    = SiteSetting::get('banner_image');
        $bannerUrl = $banner
            ? asset('storage/banners/' . $banner)
            : asset('assets/images/web-kanagwa.jpg');

        $content   = PageContent::getPage('home');
        $medias    = MediaItem::active()->get();
        $gallery   = GalleryImage::active()->get();
        $sponsors  = Sponsor::active()->get()->groupBy('tier');

        return view('home', compact('bannerUrl', 'content', 'medias', 'gallery', 'sponsors'))->render();
    }

    private function renderAbout(): string
    {
        $content      = PageContent::getPage('about');
        $venueImage1  = SiteSetting::get('about_venue_image_1');
        $venueImage2  = SiteSetting::get('about_venue_image_2');

        return view('about', compact('content', 'venueImage1', 'venueImage2'))->render();
    }

    private function renderEvent(): string
    {
        $content        = PageContent::getPage('event');
        $calendarImage1 = SiteSetting::get('event_calendar_image_1');
        $calendarImage2 = SiteSetting::get('event_calendar_image_2');
        $ambassadors    = EventPerformer::active()->byCategory('ambassador')->get();
        $supporters     = EventPerformer::active()->byCategory('supporter')->get();
        $guests         = EventPerformer::active()->byCategory('guest')->get();

        return view('event', compact(
            'content', 'calendarImage1', 'calendarImage2',
            'ambassadors', 'supporters', 'guests'
        ))->render();
    }

    private function renderMap(): string
    {
        $content     = PageContent::getPage('map');
        $mapImage    = SiteSetting::get('map_image');
        $boothGroups = MapBooth::orderBy('group_name')->orderBy('sort_order')->get()->groupBy('group_name');

        return view('map', compact('content', 'mapImage', 'boothGroups'))->render();
    }

    private function renderSponsor(): string
    {
        $content  = PageContent::getPage('sponsor');
        $sponsors = Sponsor::active()->get()->groupBy('tier');
        $tiers    = Sponsor::$tierConfig;
        $partners = PartnerCompany::active()->get();

        return view('sponsor', compact('content', 'sponsors', 'tiers', 'partners'))->render();
    }

    /**
     * Rewrite all absolute URLs inside the HTML so that the page works
     * when opened directly from the filesystem (file:///…).
     *
     * Strategy:
     *  - All asset() / url() calls produce http://localhost:8000/assets/...
     *    → replace with ./assets/...
     *  - Inter-page links: /about → about.html, etc.
     *  - Laravel CSRF / action forms: stripped (static page can't POST).
     */
    private function rewritePathsForOffline(string $html, string $currentFile): string
    {
        // ── A. Fix absolute asset URLs from asset()/url() ─────────────
        // e.g. http://localhost:8000/assets/css/style.css → ./assets/css/style.css
        $html = str_replace($this->appUrl . '/', './', $html);

        // ── B. Fix root-relative asset paths (no domain prefix) ───────
        // e.g. /assets/css/style.css → ./assets/css/style.css
        $html = preg_replace(
            '#(href|src|action)=(["\'])/assets/#',
            '$1=$2./assets/',
            $html
        );

        // Fix storage root-relative paths
        $html = preg_replace(
            '#(href|src|action)=(["\'])/storage/#',
            '$1=$2./storage/',
            $html
        );

        // ── C. Rewrite internal navigation links ──────────────────────
        $routeMap = [
            ['pattern' => '#href=(["\'])' . preg_quote($this->appUrl, '#') . '(["\'])#', 'replace' => 'href=$1index.html$2'],
            ['pattern' => '#href=(["\'])/#',        'replace' => 'href=$1index.html'],
            ['pattern' => '#href=(["\'])/about(["\'/])#',   'replace' => 'href=$1about.html$2'],
            ['pattern' => '#href=(["\'])/event(["\'/])#',   'replace' => 'href=$1event.html$2'],
            ['pattern' => '#href=(["\'])/map(["\'/])#',     'replace' => 'href=$1map.html$2'],
            ['pattern' => '#href=(["\'])/sponsor(["\'/])#', 'replace' => 'href=$1sponsor.html$2'],
        ];

        foreach ($routeMap as $rule) {
            $html = preg_replace($rule['pattern'], $rule['replace'], $html);
        }

        // ── D. Fix remaining heuristic href="/" after above ───────────
        $html = preg_replace('#href=(["\'])\./$#m', 'href=$1index.html', $html);

        // ── E. Remove CSRF tokens & forms that won't work offline ─────
        $html = preg_replace('/<input[^>]*name=["\']_token["\'][^>]*>/i', '', $html);
        $html = preg_replace('/<meta[^>]*name=["\']csrf-token["\'][^>]*>/i', '', $html);

        // ── F. Fix favicon root-relative if present ───────────────────
        $html = str_replace('href="/favicon.ico"', 'href="./favicon.ico"', $html);

        return $html;
    }

    private function createZip(string $sourcePath, string $zipFilePath): void
    {
        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Không thể tạo file ZIP: ' . $zipFilePath);
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourcePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $realPath     = $item->getRealPath();
            $relativePath = substr($realPath, strlen($sourcePath) + 1);
            // Normalize directory separator for ZIP
            $relativePath = str_replace('\\', '/', $relativePath);

            if ($item->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($realPath, $relativePath);
            }
        }

        $zip->close();
    }
}
