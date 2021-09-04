<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false, // Register Routes...
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [\App\Http\Controllers\AccountController::class, 'profile'])->name('profile');
    Route::put('/profil', [\App\Http\Controllers\AccountController::class, 'updateProfile'])->name('update_profile');
    Route::get('/ubah-password', [\App\Http\Controllers\AccountController::class, 'password'])->name('password');
    Route::put('/ubah-password', [\App\Http\Controllers\AccountController::class, 'updatePassword'])->name('update_password');

    Route::get('/ajax/keluarga/{id}', [\App\Http\Controllers\AjaxController::class, 'getKeluarga']);
    Route::get('/ajax/penduduk/{id}', [\App\Http\Controllers\AjaxController::class, 'getPenduduk']);

    Route::get('/statistik-penduduk/show', [\App\Http\Controllers\GrafikController::class, 'show']);

    Route::resource('keluarga', \App\Http\Controllers\KeluargaController::class);
    Route::resource('penduduk', \App\Http\Controllers\PendudukController::class);
    Route::resource('penduduk-domisili', \App\Http\Controllers\PendudukDomisiliController::class);
    Route::resource('penduduk-meninggal', \App\Http\Controllers\PendudukMeninggalController::class)->except('create');
    Route::resource('rumah', \App\Http\Controllers\RumahController::class);

    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('/penduduk', [\App\Http\Controllers\PendudukController::class, 'export'])->name('penduduk');
        Route::get('/penduduk-domisili', [\App\Http\Controllers\PendudukDomisiliController::class, 'export'])->name('penduduk_domisili');
        Route::get('/penduduk-meninggal', [\App\Http\Controllers\PendudukMeninggalController::class, 'export'])->name('penduduk_meninggal');
        Route::get('/keluarga', [\App\Http\Controllers\KeluargaController::class, 'export'])->name('keluarga');
        Route::get('/rumah', [\App\Http\Controllers\RumahController::class, 'export'])->name('rumah');
    });

    Route::middleware(['role:rw'])->name('rw.')->prefix('rw')->group(function () {
        Route::get('/', \App\Http\Controllers\Rw\DashboardController::class)->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Rw\UserController::class)->except('show');
    });

    Route::middleware(['role:rt'])->name('rt.')->prefix('rt')->group(function () {
        Route::get('/', \App\Http\Controllers\Rt\DashboardController::class)->name('dashboard');
    });
});

Route::fallback(function () {
    abort(404);
});