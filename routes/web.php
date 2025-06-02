<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'kurir') {
        return redirect()->route('kurir.dashboard');
    }

    abort(403, 'Unauthorized');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('surat', SuratController::class);

    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/dashboard/kurir', [DashboardController::class, 'index'])->name('kurir.dashboard');

    Route::get('/penugasan', [PenugasanController::class, "index"])->name("penugasan.index");
    Route::get('/penugasan/{id}', [PenugasanController::class, "show"])->name("penugasan.show");

    Route::put('/surat/{id}/kirim', [SuratController::class, 'kirim'])->name('penugasan.kirim');
    Route::put('/surat/{id}/selesai', [SuratController::class, 'selesai'])->name('penugasan.selesai');
});
