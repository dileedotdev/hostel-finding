<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\HostelIndexController;
use App\Http\Controllers\HostelSearchController;
use App\Models\Hostel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->group(function (): void {
    Route::get('google', [AuthController::class, 'redirectToGoogle'])
        ->name('auth.google')
    ;

    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])
        ->name('auth.google.callback')
    ;

    Route::get('facebook', [AuthController::class, 'redirectToFacebook'])
        ->name('auth.facebook')
    ;

    Route::get('facebook/callback', [AuthController::class, 'handleFacebookCallback'])
        ->name('auth.facebook.callback')
    ;
});

Route::get('', HostelIndexController::class)
    ->name('hostels.index')
;

Route::get('hostels/search', HostelSearchController::class)
    ->name('hostels.search')
;

Route::get('hostels/create', [HostelController::class, 'hosting'])
    ->can('create', [Hostel::class])
    ->name('hostels.create')
    ->middleware('auth')
;

Route::get('hostels/manage', [HostelController::class, 'manage'])
    ->can('viewOwn', [Hostel::class])
    ->name('hostels.manage')
    ->middleware('auth')
;

Route::get('hostels/{hostel}', [HostelController::class, 'show'])
    ->name('hostels.show')
;

Route::get('hostels/{hostel}/edit', [HostelController::class, 'edit'])
    ->can('update', ['hostel'])
    ->name('hostels.edit')
    ->middleware('auth')
;

Route::get('notify', [HostelController::class, 'notify'])
    ->name('hostels.notify')
    ->middleware('auth')
;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});
