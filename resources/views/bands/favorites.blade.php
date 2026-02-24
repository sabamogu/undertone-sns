@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- セクション1：お気に入り一覧 --}}
        <h3 class="text-2xl font-bold text-white mb-8 border-l-4 border-red-500 pl-4">My Favorites</h3>
        @if($favoriteBands->isEmpty())
            <p class="text-gray-500 mb-16">お気に入りに登録されたバンドはありません。</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-12">
                @foreach ($favoriteBands as $band)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-white">{{ $band->name }}</h3>
                            <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded">{{ $band->genre }}</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">{{ $band->name_kana }}</p>
                        <a href="{{ route('bands.show', $band->id) }}" class="mt-4 block text-center w-full bg-gray-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition">
                            詳細を見る
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mb-16 text-white">
                {{ $favoriteBands->links() }}
            </div>
        @endif

        {{-- セクション2：自分が投稿したバンド --}}
        <h3 class="text-2xl font-bold text-white mb-8 border-l-4 border-indigo-500 pl-4 mt-12">My Posts</h3>
        @if($myBands->isEmpty())
            <p class="text-gray-500">まだ投稿したバンドはありません。</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($myBands as $band)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-white">{{ $band->name }}</h3>
                            <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded">{{ $band->genre }}</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">{{ $band->name_kana }}</p>
                        <p class="text-xs text-gray-500 mt-2 italic">投稿日: {{ $band->created_at->format('Y/m/d') }}</p>
                        <a href="{{ route('bands.show', $band->id) }}" class="mt-4 block text-center w-full bg-gray-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition">
                            詳細を見る
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection