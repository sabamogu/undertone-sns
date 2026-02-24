<?php

use App\Http\Controllers\BandController;
use App\Http\Controllers\ProfileController; 
use Illuminate\Support\Facades\Route;

// 1. トップページ（アクセスしたら一覧へ）
Route::get('/', function () {
    return redirect()->route('bands.index');
});

// 2. ログイン後のリダイレクト先として 'dashboard' を定義しておく
Route::get('/dashboard', function () {
    return redirect()->route('bands.index');
})->name('dashboard');

// 3. 全公開ルート（ログインしてなくても見れる）
Route::get('/bands', [BandController::class, 'index'])->name('bands.index');

// 4. 認証が必要なルート
Route::middleware('auth')->group(function () {
    // プロフィール管理用のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); 
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/bands/create', [BandController::class, 'create'])->name('bands.create');
    Route::post('/bands', [BandController::class, 'store'])->name('bands.store');
    Route::get('/bands/{band}/edit', [BandController::class, 'edit'])->name('bands.edit');
    Route::put('/bands/{band}', [BandController::class, 'update'])->name('bands.update');
    Route::delete('/bands/{band}', [BandController::class, 'destroy'])->name('bands.destroy');
});
//⇩indexの下が本来。
Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show'); 

require __DIR__.'/auth.php';