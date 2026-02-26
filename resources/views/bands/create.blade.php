@extends('layouts.app')@section('content')
    <div class="max-w-xl mx-auto">
        <a href="{{ route('bands.index') }}" class="text-gray-400 hover:underline">← 戻る</a>
        <h1 class="text-white text-3xl font-bold mt-6 mb-8">新しいバンドを登録</h1>
        <form action="{{ route('bands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-gray-800 p-8 rounded-xl border border-gray-700">
            @csrf
            <div>
                <label class="text-white block text-sm font-medium mb-2">バンド名</label>
                <input type="text" name="name" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: The Laravelers" required>
            </div>
            <div>
                <label class="text-white block text-sm font-medium mb-2">カナ（検索用）</label>
                <input type="text" name="name_kana" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: ざ・ららべらーず" required>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="text-white block text-sm font-medium mb-2">ジャンル</label>
                    <select name="genre" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                        <option value="">選択してください(空欄可)</option>
                        @foreach(\App\Models\Band::$genres as $value => $label)
                            <option value="{{ $value }}" {{ old('genre') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-white block text-sm font-medium mb-2">活動地域</label>
                    <input type="text" name="area" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 下北沢">
                </div>
                <div>
                    <label class="text-white block text-sm font-medium mb-2">編成</label>
                    <input type="text" name="formation" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 3ピース、5人組など">
                </div>
                <div>
                    <label class="text-white block text-sm font-medium mb-2">所属レーベル</label>
                    <input type="text" name="label" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="空欄なら「無し」扱い">
                </div>
                <div>
                    <label class="text-white block text-sm font-medium mb-2">結成年月日</label>
                    <input type="date" name="formed_at" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" style="color-scheme: dark;">
                </div>
                </div>
                <div>
                    <label class="text-white block text-sm font-medium mb-2">バンドロゴ / 写真(.jpeg)</label>
                    <input type="file" name="image" class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
            <div>
                <label class="text-white block text-sm font-medium mb-2">YouTube動画ID</label>
                <div id="youtube-inputs-container" class="space-y-3">
                    <div class="flex gap-2">
                        <input type="text" name="youtube_urls[]"
                            class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none"
                            placeholder="例: Mfy1HCD2sTk">
                    </div>
                </div>
                <button type="button" id="add-video-btn" class="mt-3 text-sm text-indigo-400 hover:text-indigo-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    動画を追加する
                </button>
                <p class="text-xs text-gray-500 mt-1">動画ID（URLの最後11桁）を入力してください。</p>
            </div>
            <div class="flex justify-center">
            <button type="submit" class="mt-2 w-1/2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-lg transition shadow-lg">
                この内容で登録する
            </button>
            </div>
        </form>
    </div>
@endsection

<script>
    // ページが完全に読み込まれてから実行するようにする
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('youtube-inputs-container');
        const addBtn = document.getElementById('add-video-btn');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
               const newInputGroup = document.createElement('div');
                newInputGroup.className = 'flex gap-2';
                newInputGroup.innerHTML = `
                    <input type="text" name="youtube_urls[]"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none"
                        placeholder="別の動画IDを入力">
                    <button type="button" class="remove-video-btn text-red-500 hover:text-red-400 px-2">
                        ✕
                    </button>
                `;
                container.appendChild(newInputGroup);
            });
        }
        // 削除ボタンの処理
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video-btn')) {
                e.target.closest('div').remove();
            }
        });
    });
</script>