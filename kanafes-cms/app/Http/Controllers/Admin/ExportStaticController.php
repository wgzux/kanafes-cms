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
     */
    private function rewritePathsForOffline(string $html, string $currentFile): string
    {
        // 1. Prepare candidate domains (to handle both 127.0.0.1 and localhost if needed)
        // We prioritize the configured APP_URL
        $domains = [
            $this->appUrl,
            'http://localhost:8000',
            'http://127.0.0.1:8000',
        ];
        $domains = array_unique($domains);

        // 2. Fix Assets & Storage (Absolute to Relative)
        // We do this first because asset links often contain the domain
        foreach ($domains as $domain) {
            $html = str_replace($domain . '/assets/', './assets/', $html);
            $html = str_replace($domain . '/storage/', './storage/', $html);
            $html = str_replace($domain . '/favicon.ico', './favicon.ico', $html);
        }

        // 3. Fix Assets & Storage (Root-relative to Relative)
        // e.g. /assets/... -> ./assets/...
        $html = preg_replace('#(href|src|action)=(["\'])/assets/#', '$1=$2./assets/', $html);
        $html = preg_replace('#(href|src|action)=(["\'])/storage/#', '$1=$2./storage/', $html);
        $html = str_replace('href="/favicon.ico"', 'href="./favicon.ico"', $html);

        // 4. Handle Page Routes (Both Absolute and Root-relative)
        // We define the mapping from current routes to .html files
        $routes = [];
        foreach ($this->pageMap as $htmlFile => $route) {
            $routeName = ($route === 'home') ? '' : $route;
            
            foreach ($domains as $domain) {
                // Absolute: http://domain.com/about or http://domain.com/about/
                $routes[] = ['pattern' => '#href=(["\'])' . preg_quote($domain . '/' . $routeName, '#') . '/?(["\'])#', 'replacement' => 'href=$1' . $htmlFile . '$2'];
            }
            
            // Root-relative: href="/about" or href="/about/"
            if ($routeName !== '') {
                $routes[] = ['pattern' => '#href=(["\'])/' . preg_quote($routeName, '#') . '/?(["\'])#', 'replacement' => 'href=$1' . $htmlFile . '$2'];
            }
        }

        // Add special case for root "/" -> index.html
        foreach ($domains as $domain) {
            $routes[] = ['pattern' => '#href=(["\'])' . preg_quote($domain, '#') . '/?(["\'])#', 'replacement' => 'href=$1index.html$2'];
        }
        $routes[] = ['pattern' => '#href=(["\'])/(["\'])#', 'replacement' => 'href=$1index.html$2'];

        // Sort routes by pattern length descending to match longer patterns first (e.g. /about before /)
        usort($routes, function($a, $b) {
            return strlen($b['pattern']) <=> strlen($a['pattern']);
        });

        foreach ($routes as $route) {
            $html = preg_replace($route['pattern'], $route['replacement'], $html);
        }

        // 5. Cleanup Laravel-specific tags that break offline
        $html = preg_replace('/<input[^>]*name=["\']_token["\'][^>]*>/i', '', $html);
        $html = preg_replace('/<meta[^>]*name=["\']csrf-token["\'][^>]*>/i', '', $html);

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
