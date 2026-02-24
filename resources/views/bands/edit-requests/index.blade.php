@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('bands.show', $band) }}" class="text-gray-400 hover:text-white transition underline">← バンド詳細に戻る</a>
        
        <h1 class="text-white text-3xl font-bold mt-6 mb-8">編集提案の確認</h1>

        @foreach($requests as $request)
            <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-700 bg-gray-800/50 flex justify-between items-center">
                    <div>
                        <span class="text-indigo-400 text-sm font-bold">提案者: {{ $request->user->name }}</span>
                        <p class="text-gray-500 text-xs">{{ $request->created_at->format('Y/m/d H:i') }}</p>
                    </div>
                </div>

                <div class="p-6">
                    <table class="w-full text-left text-gray-300">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase tracking-wider">
                                <th class="pb-4 w-1/4">項目</th>
                                <th class="pb-4 w-1/4 text-red-400/70 italic">現在の内容</th>
                                <th class="pb-4 w-1/2 text-green-400 font-bold">提案された内容</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <tr>
                                <td class="py-4 text-sm">バンド名</td>
                                <td class="py-4 text-sm">{{ $band->name }}</td>
                                <td class="py-4 text-lg text-white font-bold">{{ $request->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm">カナ</td>
                                <td class="py-4 text-sm">{{ $band->name_kana }}</td>
                                <td class="py-4 text-white">{{ $request->name_kana }}</td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm">活動地域</td>
                                <td class="py-4 text-sm">{{ $band->area }}</td>
                                <td class="py-4 text-white font-bold">{{ $request->area }}</td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm">編成</td>
                                <td class="py-4 text-sm">{{ $band->formation }}</td>
                                <td class="py-4 text-white font-bold">{{ $request->formation }}</td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm">結成年月日</td>
                                <td class="py-4 text-sm">{{ $band->formed_at }}</td>
                                <td class="py-4 text-white font-bold">{{ $request->formed_at }}</td>
                            </tr>
                                                        <tr>
                                <td class="py-4 text-sm">ジャンル</td>
                                <td class="py-4 text-sm">{{ $band->genre }}</td>
                                <td class="py-4 text-white">{{ $request->genre }}</td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm">YouTube動画ID</td>
                                <td class="py-4 text-xs text-gray-500">{{ implode(', ', $band->youtube_urls ?? []) }}</td>
                                <td class="py-4 text-white">
                                    @foreach($request->youtube_urls ?? [] as $url)
                                        <span class="inline-block bg-gray-700 px-2 py-1 rounded text-xs mr-1">{{ $url }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-900/50 flex justify-end space-x-4">
                    {{-- 却下フォーム --}}
                    <form action="{{ route('edit-requests.reject', $request) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-400 text-sm font-bold px-4 py-2 transition" onclick="return confirm('この提案を却下しますか？')">
                            却下する
                        </button>
                    </form>

                    {{-- 承認フォーム --}}
                    <form action="{{ route('edit-requests.approve', $request) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-500 text-white font-bold px-8 py-2 rounded-lg shadow-lg transition" onclick="return confirm('この内容でバンド情報を上書きしますか？')">
                            承認して更新
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection