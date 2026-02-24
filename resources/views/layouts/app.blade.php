<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-gray-900"> {{-- 背景色を以前の暗い色に --}}
        <div class="min-h-screen">
            {{-- ナビゲーションバーを表示 --}}
            @include('layouts.navigation')

            <main>
                {{-- $slot ではなく @yield('content') を使うように戻す --}}
                @yield('content')
            </main>
            {{-- 現在のルート名が 'bands.index' の時だけ表示 --}}
            @if(request()->routeIs('bands.index'))
                @include('components.contact-form')
            @else
                {{-- それ以外のページではコピーライトのみ表示するフッターを置く --}}
                <footer class="bg-gray-900 py-8 border-t border-gray-800 text-center">
                    <p class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} UNDER TONE. All rights reserved.
                    </p>
                </footer>
            @endif
        </div>
    </body>
</html>