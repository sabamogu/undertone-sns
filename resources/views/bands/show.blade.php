<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $band->name }} - UnderTone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100 p-6">
    <div class="max-w-2xl mx-auto">
        <a href="{{ url('/bands') }}" class="text-indigo-400 hover:underline">← 一覧に戻る</a>

        <div class="flex justify-end">
            <a href="{{ route('bands.edit', $band->id) }}" class="bg-indigo-600 px-4 py-2 mr-4 rounded text-sm font-bold">
                情報を編集する
            </a>
            <form action="{{ route('bands.destroy', $band->id) }}" method="POST" onsubmit="return confirm('本当にこのバンドを削除してもよろしいですか？');">
                @csrf
                @method('DELETE') <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-medium underline">
                    このバンドを削除する
                </button>
            </form>
        </div>
        
        <div class="mt-8 bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700">
            @if($band->image_path)
                <img src="{{ asset('storage/' . $band->image_path) }}" alt="{{ $band->name }}" class="w-full rounded-lg">
            @else
                <div class="w-full h-48 bg-gray-700 flex items-center justify-center rounded-lg">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold">{{ $band->name }}</h1>
                <span class="bg-indigo-600 px-3 py-1 rounded-full text-sm">{{ $band->genre }}</span>
            </div>

            <div class="grid grid-cols-2 gap-6 text-gray-300">
                <div>
                    <p class="text-gray-500 text-xs uppercase">カナ</p>
                    <p class="text-lg">{{ $band->name_kana }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">ジャンル</p>
                    <p class="text-lg">{{ $band->genre }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">活動地域</p>
                    <p class="text-lg">{{ $band->area }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">編成</p>
                    <p class="text-lg">{{ $band->formation }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">所属レーベル</p>
                    <p class="text-lg">
                        {{ $band->label ? $band->label : '無し' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase">結成</p>
                    <p class="text-lg">{{ $band->formed_at }}</p>
                </div>
            </div>

            <div class="mt-10">
                <p class="text-gray-400 mb-4 font-bold">Featured Video</p>
                @if($band->youtube_url)
                    <div class="aspect-video">
                        <iframe class="w-full h-full rounded-lg shadow-2xl" 
                            src="https://www.youtube.com/embed/{{ $band->youtube_url }}"
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <div class="aspect-video bg-gray-700 rounded-lg flex items-center justify-center border border-gray-600">
                        <p class="text-gray-500 text-sm">動画はまだ登録されていません</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>

