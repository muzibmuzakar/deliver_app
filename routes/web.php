<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Contoh halaman role-protected
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.index');
    })->name('admin.dashboard');

    Route::resource('surat', SuratController::class);

    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/dashboard/kurir', function () {
        return view('dashboard.index');
    })->name('kurir.dashboard');

    Route::get('/penugasan', [PenugasanController::class, "index"])->name("penugasan.index");
    // Route::get('/penugasan/kirim', [PenugasanController::class, "index"])->name("penugasan.kirim");
    // Route::get('/penugasan/selesai', [PenugasanController::class, "index"])->name("penugasan.selesai");

    Route::put('/surat/{id}/kirim', [SuratController::class, 'kirim'])->name('surat.kirim');
    Route::put('/surat/{id}/selesai', [SuratController::class, 'selesai'])->name('surat.selesai');
});
