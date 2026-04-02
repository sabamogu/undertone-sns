<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test-cors', function () {
    return response()->json(['message' => 'URLは合ってる']);
});

Route::post('/contact', function (Request $request) {
    // バリデーションチェック（わざとエラーを起こすため）
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
    ]);

    return response()->json(['message' => '送信成功！']);
});
