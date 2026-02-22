@extends('layouts.app')@section('content')
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
                <h1 class="mix-blend-defference mt-2 text-4xl font-bold">{{ $band->name }}</h1>
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
    </div>
@endsection
