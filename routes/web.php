<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BandController;

// 「/bands という URL に GET リクエストが来たら、BandController の index メソッドを実行する」一覧画面
Route::get('/bands', [BandController::class, 'index'])->name('bands.index');

// 登録画面（showより上に書く）
Route::get('/bands/create', [BandController::class, 'create'])->name('bands.create');

// 保存処理 データを保存する道（POSTメソッドを使うのがポイント！）
Route::post('/bands', [BandController::class, 'store'])->name('bands.store');

//詳細画面（一番下）
Route::get('/bands/{id}', [BandController::class, 'show'])->name('bands.show');

// 編集画面を表示する道
Route::get('/bands/{id}/edit', [BandController::class, 'edit'])->name('bands.edit');

// データを更新する道（PUTまたはPATCHメソッドを使うのが一般的です）
Route::put('/bands/{id}', [BandController::class, 'update'])->name('bands.update');

// データを削除する道（DELETEメソッドを使います）
Route::delete('/bands/{id}', [BandController::class, 'destroy'])->name('bands.destroy');

// Route::get('/', function () {
    // return view('welcome');
// });
