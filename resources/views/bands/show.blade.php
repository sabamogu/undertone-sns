@extends('layouts.app')@section('content')
    @if (session('status'))
        <div class="max-w-4xl mx-auto mb-6">
            <div class="bg-green-600 text-white p-4 rounded-lg shadow-lg font-bold">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <div class="max-w-2xl mx-auto">
        <a href="{{ url('/bands') }}" class="text-indigo-400 hover:underline">← 一覧に戻る</a>

        <div class="flex justify-end">
            {{-- 1. 投稿者（または管理者）本人の場合 --}}
            @can('update', $band)
                @if($editRequestCount > 0)
                    <div class="bg-indigo-900/80 border border-indigo-500 text-white p-4 rounded-xl mb-4 mr-4 flex justify-between items-center shadow-lg">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">📢</span>
                            <div>
                                <span class="font-bold block">編集提案が {{ $editRequestCount }} 件届いています！</span>
                                <p class="text-xs text-indigo-300">内容を確認して承認・却下を選択してください。</p>
                            </div>
                        </div>
                        <a href="{{ route('bands.edit-requests.index', $band) }}" class="bg-indigo-500 hover:bg-indigo-400 px-4 py-2 rounded-lg text-sm font-bold transition whitespace-nowrap ml-4">
                            内容を確認
                        </a>
                    </div>
                @endif

                <div class="flex items-center space-x-4 mb-8">
                    <a href="{{ route('bands.edit', $band) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg transition shadow-md">
                        編集する
                    </a>
                    
                    <form action="{{ route('bands.destroy', $band) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-medium underline">
                            このバンドを削除する
                        </button>
                    </form>
                </div>

            {{-- 2. 投稿者以外（他人の投稿）の場合 --}}
            @else
                <div class="mb-8">
                    <a href="{{ route('bands.propose-edit', $band) }}" class="inline-block bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                        ✨ このバンドの情報を修正する
                    </a>
                </div>
            @endcan
        </div>
        
        <div class="mt-8 bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700">
            @if($band->image_path)
                <img src="{{ asset('storage/' . $band->image_path) }}" alt="{{ $band->name }}" class="w-full rounded-lg">
            @else
                <div class="w-full h-48 bg-gray-700 flex items-center justify-center rounded-lg">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-white mix-blend-defference mt-4 text-4xl font-bold">{{ $band->name }}</h1>
                <span class="bg-indigo-600 px-3 py-1 rounded-full text-sm">{{ $band->genre }}</span>
            </div>

                <form action="{{ route('bands.favorite', $band) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 focus:outline-none">
                        @if($band->isFavoritedBy(auth()->user()))
                            {{-- お気に入り済み：赤いハート --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500 fill-current" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        @else
                            {{-- 未お気に入り：枠線だけのハート --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 hover:text-red-500 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        @endif
                        <span class="text-gray-400 text-sm">{{ $band->favoritedBy()->count() }}</span>
                    </button>
                </form>

            <div class="grid grid-cols-2 gap-6 text-gray-300 mt-6">
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
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    {{-- 配列が空でないか、かつ配列であることを確認 --}}
            @if(!empty($band->youtube_urls) && is_array($band->youtube_urls))
                
                @foreach($band->youtube_urls as $url)
                    {{-- $url が空でない場合のみ表示 --}}
                    @if($url)
                        <div class="aspect-video">
                            <iframe 
                                class="w-full h-full rounded-xl shadow-lg" 
                                src="https://www.youtube.com/embed/{{ $url }}" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                @endforeach
                @else
                    <div class="aspect-video bg-gray-700 rounded-lg flex items-center justify-center border border-gray-600">
                        <p class="text-gray-500 text-sm">動画はまだ登録されていません</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-gray-800">
            <div class="flex items-center justify-end text-sm text-gray-400">
                <span class="mr-2">初期登録者:</span>
                {{-- Bandモデルからリレーション経由でユーザー名を呼び出す --}}
                <div class="flex items-center">
                    <span class="text-gray-200 font-medium">{{ $band->user->name }}</span>
                    <span class="ml-2 italic text-xs">({{ $band->created_at->format('Y/m/d') }})</span>
                </div>
            </div>
        </div>
    </div>
@endsection