<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/add-mood', [App\Http\Controllers\MoodController::class, 'create'])->name('add-mood');
Route::post('/save-mood', [App\Http\Controllers\MoodController::class, 'store'])->name('save-mood');

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [App\Http\Controllers\MoodController::class, 'history'])->name('history');
    Route::get('/get-history', [App\Http\Controllers\MoodController::class, 'getHistory'])->name('get-history');
    Route::post('/delete-mood', [App\Http\Controllers\MoodController::class, 'destroy'])->name('delete-mood');
    Route::get('/weekly-report', [App\Http\Controllers\ReportController::class, 'index'])->name('weekly-report');
    Route::get('/get-report', [App\Http\Controllers\ReportController::class, 'getReport'])->name('get-report');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('update-photo');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support');
Route::post('/save-feedback', [App\Http\Controllers\SupportController::class, 'saveFeedback'])->name('save-feedback');
Route::get('/partner', [App\Http\Controllers\PartnerController::class, 'index'])->name('partner');
Route::get('/playlists/{id}', [App\Http\Controllers\PlaylistController::class, 'show'])->name('playlists.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/users/{user}/logs', [App\Http\Controllers\Admin\UserController::class, 'logs'])->name('users.logs');

    // Support Tickets
    Route::get('/support', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support.index');
    Route::post('/support/{message}/status', [App\Http\Controllers\Admin\SupportController::class, 'updateStatus'])->name('support.update-status');

    // Content Management
    Route::get('/content', [App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
    Route::post('/content/playlists', [App\Http\Controllers\Admin\ContentController::class, 'storePlaylist'])->name('content.playlists.store');
    Route::post('/content/media', [App\Http\Controllers\Admin\ContentController::class, 'storeMedia'])->name('content.media.store');

    // System Metrics
    Route::get('/metrics', [App\Http\Controllers\Admin\AdminController::class, 'metrics'])->name('metrics');
});
// Legal & Info Pages
Route::get('/imprint', function () { return view('pages.imprint'); })->name('imprint');
Route::get('/privacy-policy', function () { return view('pages.privacy_policy'); })->name('privacy_policy');
Route::get('/terms', function () { return view('pages.terms'); })->name('terms');
Route::get('/medical-device', function () { return view('pages.medical_device'); })->name('medical_device');
