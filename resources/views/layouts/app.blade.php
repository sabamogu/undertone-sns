<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undertone SNS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-montserrat">

    <header class="bg-gray-800 shadow-md py-4 mb-8">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('bands.index') }}" class="text-2xl font-bebas tracking-widest text-indigo-500">
                UNDER TONE
            </a>

            <form action="{{ route('bands.index') }}" method="GET" class="flex w-full md:w-auto">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                    placeholder="バンド名、ジャンル..." 
                    class="bg-gray-900 text-white border border-gray-700 rounded-l-lg px-4 py-2 w-full md:w-64 focus:outline-none focus:border-indigo-500">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-r-lg transition">
                    検索
                </button>
            </form>
        </div>
    </header>

    <main class="container mx-auto px-4">
        @include('components.errors')

        @yield('content')
    </main>

    <footer class="mt-12 py-8 border-t border-gray-800 text-center text-gray-500 text-sm">
        &copy; 2026 Undertone SNS.
    </footer>

</body>
</html>
