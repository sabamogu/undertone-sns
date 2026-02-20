@extends('layouts.app') 

@section('content') 
<div class="max-w-4xl mx-auto p-6">
    <header class="mb-10 text-center">
        <h1 class="text-6xl font-bebas tracking-widest text-indigo-500">UNDER TONE</h1>
        <p class="text-gray-400 mt-2">あなたの知らない未知の音楽がここにある。<br>Uncover music you never knew existed.</p>

        <div class="mt-8 mb-10 p-8 bg-gray-800/50 border border-gray-700 rounded-2xl shadow-xl max-w-2xl mx-auto text-left">
            <h2 class="text-xl text-indigo-400 mb-4 flex items-center italic">
                About Under Tone
            </h2>
            <p class="text-gray-300 leading-relaxed text-sm md:text-base">
                ～「誰も知らない」から「誰もが知ってる」へ～
                UnderTone（アンダートーン）は、まだ見ぬ熱狂を探すための「インディーズバンド特化型」<br>
                データベースです。 「もっと色んなバンドを知りたい！聴きたい！」サイト主のそんな想いから<br>
                生まれました。すべての音楽ファンのために、全国のバンド情報を集約し、共有することを目指しています。
            </p>
            <div class="mt-4 flex flex-wrap gap-4 text-xs text-gray-400">
                <span class="flex items-center">🔍 50音・キーワード検索</span>
                <span class="flex items-center">🎥 YouTube動画チェック</span>
                <span class="flex items-center">🎸 誰でも登録可能</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('bands.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                + 新しいバンドを登録する
            </a>
        </div>
    </header>

    <main>
        <div class="mb-10 bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-inner">
            <p class="text-sm text-gray-400 mb-4 font-semibold">50音・アルファベットで探す</p>
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach(['あ', 'か', 'さ', 'た', 'な', 'は', 'ま', 'や', 'ら', 'わ'] as $row)
                    <a href="{{ url('/bands?kana=' . $row) }}" class="px-4 py-2 bg-gray-700 hover:bg-indigo-600 text-white rounded-md text-sm font-bold transition shadow-sm">
                        {{ $row }}
                    </a>
                @endforeach
                <a href="{{ url('/bands') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-md text-sm font-bold transition">すべて</a>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach(range('A', 'Z') as $char)
                    <a href="{{ url('/bands?alpha=' . $char) }}" class="px-3 py-1 bg-gray-900 hover:bg-indigo-500 text-gray-300 hover:text-white rounded text-xs transition border border-gray-700">
                        {{ $char }}
                    </a>
                @endforeach
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-6 border-b border-gray-700 pb-2">バンド一覧</h2>
        
        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($bands as $band)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
                    <div class="flex justify-between items-start">
                        <h3 class="text-xl font-bold text-white">{{ $band->name }}</h3>
                        <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded">{{ $band->genre }}</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-1">{{ $band->name_kana }}</p>
                    <a href="{{ route('bands.show', $band->id) }}" class="mt-2 block text-center w-full bg-gray-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition">
                        詳細を見る
                    </a>
                </div>
            @empty
                <p class="text-gray-500">現在、登録されているバンドはありません。</p>
            @endforelse
        </div>
    </main>
</div>

@endsection