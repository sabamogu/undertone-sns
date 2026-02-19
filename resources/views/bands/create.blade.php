<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>バンド登録 - UnderTone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100 p-6">
    <div class="max-w-xl mx-auto">
        <a href="{{ route('bands.index') }}" class="text-gray-400 hover:underline">← 戻る</a>
        
        <h1 class="text-3xl font-bold mt-6 mb-8">新しいバンドを登録</h1>

        <form action="{{ route('bands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-gray-800 p-8 rounded-xl border border-gray-700">
            @csrf 
            <div>
                <label class="block text-sm font-medium mb-2">バンド名</label>
                <input type="text" name="name" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: The Laravelers" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">カナ（検索用）</label>
                <input type="text" name="name_kana" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: ざ・ららべらーず" required>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium mb-2">ジャンル</label>
                    <input type="text" name="genre" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: Rock">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">活動地域</label>
                    <input type="text" name="area" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 下北沢">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">編成</label>
                    <input type="text" name="formation" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 3ピース、5人組など">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">所属レーベル</label>
                    <input type="text" name="label" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="空欄なら「無し」扱い">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">結成年月日</label>
                    <input type="date" name="formed_at" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">YouTube動画ID</label>
                    <input type="text" name="youtube_url" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: Mfy1HCD2sTk">
                    <p class="text-xs text-gray-500 mt-1">URLの「?」の前の11桁を入力してください</p>
                </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">バンドロゴ / 写真</label>
                    <input type="file" name="image" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
            <div class="flex justify-center">
            <button type="submit" class="mt-2 w-1/2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-lg transition shadow-lg">
                この内容で登録する
            </button>
            </div>
        </form>
    </div>
</body>
</html>