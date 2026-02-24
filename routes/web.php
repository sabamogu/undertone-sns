<?php

use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request;
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

Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show'); 

Route::post('/contact', function (Request $request) {
    // 1. バリデーションを実行
    $validator = Validator::make($request->all(), [
        'name'    => 'required|max:50',
        'email'   => 'required|email|max:255',
        'message' => 'required|min:10|max:2000',
    ], [
        'name.required'    => 'お名前を入力してください。',
        'email.required'   => 'メールアドレスを入力してください。',
        'email.email'      => '正しいメールアドレスの形式で入力してください。',
        'message.required' => 'お問い合わせ内容を入力してください。',
        'message.min'      => 'お問い合わせ内容は10文字以上で入力してください。',
    ]);

    // 2. バリデーションに失敗した場合の処理
    if ($validator->fails()) {
        return redirect(url()->previous() . '#contact')
            ->withErrors($validator) // エラー内容を渡す
            ->withInput();           // 入力内容を保持する（old関数用）
    }

    // 3. 成功した場合の処理（前回設定した通り）
    return redirect(url()->previous() . '#contact')
        ->with('status', '（デモ用）お問い合わせを送信しました！内容の確認とバリデーションに成功しました。');
})->name('contact.send');

require __DIR__.'/auth.php';