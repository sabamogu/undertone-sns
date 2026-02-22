@extends('layouts.app')@section('content')
    <div class="max-w-xl mx-auto">
        <a href="{{ route('bands.index') }}" class="text-gray-400 hover:underline">← 戻る</a>
        
        <h1 class="text-3xl font-bold mt-6 mb-8">バンド編集</h1>

        <form action="{{ route('bands.update', $band->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-gray-800 p-8 rounded-xl border border-gray-700">
            @csrf 
            @method('PUT')<div>
                <label class="block text-sm font-medium mb-2">バンド名</label>
                <input type="text" name="name" value="{{ $band->name }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: The Laravelers" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">カナ（検索用）</label>
                <input type="text" name="name_kana" value="{{ $band->name_kana }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: ざ・ららべらーず" required>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium mb-2">ジャンル</label>
                    <select name="genre" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                        <option value="">選択してください</option>
                        @foreach(\App\Models\Band::$genres as $value => $label)
                            <option value="{{ $value }}" {{ $band->genre == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">活動地域</label>
                    <input type="text" name="area" value="{{ $band->area }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 下北沢">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">編成</label>
                    <input type="text" name="formation" value="{{ $band->formation }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: 3ピース、5人組など">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">所属レーベル</label>
                    <input type="text" name="label" value="{{ $band->label }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="空欄なら「無し」扱い">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">結成年月日</label>
                    <input type="date" name="formed_at" value="{{ $band->formed_at }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
            </div>
                <div>
                    <label class="block text-sm font-medium mb-2">バンドロゴ / 写真</label>
                    <input type="file" name="image" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">YouTube動画ID</label>
                    
                    <div id="youtube-inputs-container" class="space-y-3">
                        @if(!empty($band->youtube_urls) && is_array($band->youtube_urls))
                            @foreach($band->youtube_urls as $url)
                                <div class="flex gap-2">
                                    <input type="text" name="youtube_urls[]" value="{{ $url }}" 
                                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" 
                                        placeholder="例: Mfy1HCD2sTk">
                                    <button type="button" class="remove-video-btn text-red-500 hover:text-red-400 px-2 font-bold">
                                        ✕
                                    </button>
                                </div>
                            @endforeach
                        @else
                            {{-- 動画が一つも登録されていない場合、空の入力欄を1つ出す --}}
                            <div class="flex gap-2">
                                <input type="text" name="youtube_urls[]" 
                                    class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" 
                                    placeholder="例: Mfy1HCD2sTk">
                            </div>
                        @endif
                    </div>

                    <button type="button" id="add-video-btn" class="mt-3 text-sm text-indigo-400 hover:text-indigo-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        動画を追加する
                    </button>
                </div>
                    </div>
                        <p class="text-xs text-gray-500 mt-1">URLの「?」の前の11桁を入力してください</p>
                    </div>
                
            <div class="flex justify-center">
            <button type="submit" class="mt-2 w-1/2 py-4 bg-green-600 hover:bg-green-500 rounded transition">
                更新する
            </button>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('youtube-inputs-container');
        const addBtn = document.getElementById('add-video-btn');

        // 追加ボタンの処理
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const newInputGroup = document.createElement('div');
                newInputGroup.className = 'flex gap-2';
                newInputGroup.innerHTML = `
                    <input type="text" name="youtube_urls[]" 
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" 
                        placeholder="別の動画IDを入力">
                    <button type="button" class="remove-video-btn text-red-500 hover:text-red-400 px-2 font-bold">
                        ✕
                    </button>
                `;
                container.appendChild(newInputGroup);
            });
        }

        // 削除ボタンの処理（既存・新規両方の削除ボタンに対応）
        container.addEventListener('click', function(e) {
            // クリックされたのが remove-video-btn クラスを持つ要素（またはその子要素）かチェック
            if (e.target.classList.contains('remove-video-btn')) {
                // 入力欄が1つしかない場合は消さない、などの制限をつけたい場合はここで判定
                e.target.closest('div').remove();
            }
        });
    });
</script>
