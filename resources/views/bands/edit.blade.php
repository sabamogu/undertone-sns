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
                <div>
                    <label class="block text-sm font-medium mb-2">YouTube動画ID</label>
                    <input type="text" name="youtube_url" value="{{ $band->youtube_url }}"class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none" placeholder="例: Mfy1HCD2sTk">
                    <p class="text-xs text-gray-500 mt-1">URLの「?」の前の11桁を入力してください</p>
                </div>
            </div>
                <div>
                    <label class="block text-sm font-medium mb-2">バンドロゴ / 写真</label>
                    <input type="file" name="image" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:border-indigo-500 outline-none">
                </div>
            <div class="flex justify-center">
            <button type="submit" class="mt-2 w-1/2 py-4 bg-green-600 hover:bg-green-500 rounded transition">
                更新する
            </button>
            </div>
        </form>
    </div>
@endsection
