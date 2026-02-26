@extends('layouts.app') 

@section('content') 
<div class="max-w-4xl mx-auto p-6">
    <header class="mb-10 text-center">
        <h1 class="text-6xl font-bebas tracking-widest text-indigo-500">UNDER TONE</h1>
        <p class="text-gray-400 mt-2">あなたの知らない未知の音楽がここにある。<br>Uncover music you never knew existed.</p>
            @if (session('status'))
                <div style="background-color: #28a745; color: white; padding: 15px; text-align: center; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif
        <div class="mt-8 mb-10 p-8 bg-gray-800/50 border border-gray-700 rounded-2xl shadow-xl max-w-2xl mx-auto text-left">
            <h2 class="text-xl text-indigo-400 mb-4 flex items-center italic">
                About Under Tone
            </h2>
            <p class="text-gray-300 leading-relaxed text-sm md:text-base">
                ～「誰も知らない」から「誰もが知ってる」へ～<br>
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
        @auth
            <a href="{{ route('bands.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">+ 新しいバンドを登録する</a>
        @else
            <a href="{{ route('login') }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">+ 新規登録（ログインが必要です）</a>
        @endauth
        </div>
    </header>

    <main>
        <div class="mb-10 bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-inner">
            <p class="text-sm text-gray-400 mb-4 font-semibold">50音・アルファベットで探す</p>
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach(['あ', 'か', 'さ', 'た', 'な', 'は', 'ま', 'や', 'ら', 'わ'] as $row)
                    <a href="{{ url('/bands?kana=' . $row) }}" 
                    class="px-4 py-2 rounded-md text-sm font-bold transition shadow-sm 
                    {{ request('kana') === $row ? 'bg-indigo-600 text-white' : 'bg-gray-700 hover:bg-indigo-500 text-white' }}">
                        {{ $row }}
                    </a>
                @endforeach
                <a href="{{ url('/bands') }}" 
                    class="px-4 py-2 rounded-md text-sm font-bold transition 
                    {{ !request('kana') && !request('alpha') && !request('keyword') ? 'bg-indigo-600 text-white' : 'bg-gray-600 hover:bg-gray-500 text-white' }}">
                    すべて
                </a>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach(range('A', 'Z') as $char)
                    <a href="{{ url('/bands?alpha=' . $char) }}" 
                        class="px-3 py-1 rounded text-xs transition border 
                        {{ request('alpha') === $char ? 'bg-indigo-500 text-white border-indigo-500' : 'bg-gray-900 text-gray-300 hover:text-white border-gray-700 hover:bg-indigo-500' }}">
                         {{ $char }}
                    </a>
                @endforeach
            </div>
        </div>

        <h2 class="mix-blend-defference text-2xl font-bold mb-6 border-b border-gray-700 pb-2 text-white">バンド一覧</h2>
        
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
                <div class="col-span-full text-center py-10 bg-gray-800/30 rounded-xl border border-dashed border-gray-700">
                    <p class="text-gray-500 text-lg">「{{ request('kana') ?: request('alpha') ?: request('keyword') }}」に一致するバンドは見つかりませんでした。</p>
                    <a href="{{ url('/bands') }}" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300 underline">
                        検索をリセットする
                    </a>
                </div>
            @endforelse
            <div class="mt-8">
                {{ $bands->appends(request()->query())->links() }}
            </div>
            {{-- 送信成功メッセージの表示 --}}
            @if (session('status'))
                <div style="background-color: #28a745; color: white; padding: 15px; text-align: center; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif
            <div class="mt-8 text-center">
                <a href="{{ route('bands.index') }}" class="inline-flex items-center text-gray-400 hover:text-white transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    ページトップへ戻る
                </a>
            </div>
        </div>
    </main>
</div>

@endsection
