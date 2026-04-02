<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\PageContentController;

// =============================================
// PUBLIC ROUTES
// =============================================
Route::get('/',        [HomeController::class,    'index'])->name('home');
Route::get('/about',   [AboutController::class,   'index'])->name('about');
Route::get('/event',   [EventController::class,   'index'])->name('event');
Route::get('/map',     [MapController::class,     'index'])->name('map');
Route::get('/sponsor', [SponsorController::class, 'index'])->name('sponsor');

// =============================================
// ADMIN AUTH ROUTES
// =============================================
Route::get('/admin/login', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('admin.login');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        if (auth()->user()->role !== 'admin') {
            \Illuminate\Support\Facades\Auth::logout();
            return back()->withErrors(['email' => 'Tài khoản không có quyền Admin.']);
        }
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
})->name('admin.login.post');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');

// =============================================
// ADMIN PROTECTED ROUTES
// =============================================
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Banner
    Route::get('/banner',  [BannerController::class, 'index'])->name('banner.index');
    Route::post('/banner', [BannerController::class, 'update'])->name('banner.update');

    // Gallery
    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::post('/gallery/order', [GalleryController::class, 'updateOrder'])->name('gallery.order');

    // Media (YouTube / Facebook)
    Route::get('/media',  [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'update'])->name('media.update');

    // Sponsors
    Route::resource('sponsors', AdminSponsorController::class)->except(['show']);

    // Page Contents
    Route::get('/page-contents',               [PageContentController::class, 'index'])->name('page-contents.index');
    Route::get('/page-contents/{page}/edit',   [PageContentController::class, 'edit'])->name('page-contents.edit');
    Route::put('/page-contents/{page}',        [PageContentController::class, 'update'])->name('page-contents.update');
});
