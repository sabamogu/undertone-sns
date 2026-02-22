<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BandController; // これが必要！
use Illuminate\Support\Facades\Route;

// トップページにアクセスしたら一覧へ
Route::get('/', function () {
    return redirect()->route('bands.index');
});

// --- 【ここから書き戻し】誰でも見れるページ ---
Route::get('/bands', [BandController::class, 'index'])->name('bands.index');

// お問い合わせ（バリデーション入り）
Route::post('/contact', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name'    => 'required|max:50',
        'email'   => 'required|email|max:255',
        'message' => 'required|min:10|max:2000',
    ]);
    return back()->with('status', '（デモ用）お問い合わせを送信しました！');
})->name('contact.send');
// --- 【ここまで】 ---

// ダッシュボード（Breeze標準）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ログインしている人だけが使える機能（認証グループ）
Route::middleware('auth')->group(function () {
    // Breeze標準のプロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 【ここから書き戻し】バンドの登録・編集・削除 ---
    Route::get('/bands/create', [BandController::class, 'create'])->name('bands.create');
    Route::post('/bands', [BandController::class, 'store'])->name('bands.store');
    Route::get('/bands/{id}/edit', [BandController::class, 'edit'])->name('bands.edit');
    Route::put('/bands/{band}', [BandController::class, 'update'])->name('bands.update');
    Route::delete('/bands/{id}', [BandController::class, 'destroy'])->name('bands.destroy');
    // --- 【ここまで】 ---

    // ---誰でも見れるページ ---
    Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show');
});

require __DIR__.'/auth.php';

?>
