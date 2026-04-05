<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    //許可するパス（URLのパターン）
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    //許可するメソッド（GET, POST, etc.）
    'allowed_methods' => ['*'],

    //許可するオリジン（アクセス元のドメイン）
    'allowed_origins' => [
    'https://undertone-production.up.railway.app',  //本番の自分のドメイン
    'http://localhost',     //ローカル開発用（これを忘れると自分のPCで動かなくなる）
    ],
    
    'allowed_origins_patterns' => [],

    //許可するヘッダー（Content-Type など）
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    //キャッシュの有効期限
    'max_age' => 0,

    //クッキーや認証情報の送信を許可するか
    'supports_credentials' => false,

];
