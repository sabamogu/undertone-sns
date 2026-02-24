<?php

namespace App\Http\Controllers;

use App\Models\Band; //Bandモデルを使う宣言
use Illuminate\Http\Request;

class BandController extends Controller
{

    public function index(Request $request)
    {
        $query = Band::query();

        // 1. キーワード検索 (既存の便利な機能を維持)
        if ($request->filled('keyword')) {
            $input = $request->input('keyword');
            $keywords = [
                $input,
                mb_convert_kana($input, "KVC"), // 全角カタカナ
                mb_convert_kana($input, "r"),   // 半角英数字
            ];

            foreach (\App\Models\Band::$genres as $en => $ja) {
                if (str_contains($input, $ja)) {
                    $keywords[] = $en;
                }
            }

            $keywords = array_unique($keywords);

            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('name', 'like', "%{$word}%")
                    ->orWhere('genre', 'like', "%{$word}%")
                    ->orWhere('area', 'like', "%{$word}%");
                }
            });
        }

        // 2. 50音検索 (修正案)
        if ($request->filled('kana')) {
            $kana = $request->input('kana');
            
            // 行（あ・か・さ...）ごとの検索範囲を配列で定義
            $ranges = [
                'あ' => ['あ', 'い', 'う', 'え', 'お'],
                'か' => ['か', 'き', 'く', 'け', 'こ', 'が', 'ぎ', 'ぐ', 'げ', 'ご'],
                'さ' => ['さ', 'し', 'す', 'せ', 'そ', 'ざ', 'じ', 'ず', 'ぜ', 'ぞ'],
                'た' => ['た', 'ち', 'つ', 'て', 'と', 'だ', 'ぢ', 'づ', 'で', 'ど'],
                'な' => ['な', 'に', 'ぬ', 'ね', 'の'],
                'は' => ['は', 'ひ', 'ふ', 'へ', 'ほ', 'ば', 'び', 'ぶ', 'べ', 'ぼ', 'ぱ', 'ぴ', 'ぷ', 'ぺ', 'ぽ'],
                'ま' => ['ま', 'み', 'む', 'め', 'も'],
                'や' => ['や', 'ゆ', 'よ'],
                'ら' => ['ら', 'り', 'る', 'れ', 'ろ'],
                'わ' => ['わ', 'を', 'ん'],
            ];

            if (isset($ranges[$kana])) {
                // 例：「さ」なら「さ%」「し%」「す%」...のいずれかに一致すればOK
                $query->where(function($q) use ($ranges, $kana) {
                    foreach ($ranges[$kana] as $char) {
                        $q->orWhere('name_kana', 'like', $char . '%');
                    }
                });
            } else {
                $query->where('name_kana', 'like', $kana . '%');
            }
        }

        // 3. アルファベット検索 (修正ポイント)
        if ($request->filled('alpha')) {
            $alpha = $request->input('alpha');
            $query->where('name', 'like', $alpha . '%');
        }

        // 4. 最後にまとめて取得
        // orderBy と paginate は $query に対して一度だけ行います
        $bands = $query->orderBy('name_kana', 'asc')->paginate(10);

        // 5. ページ移動時に検索条件（kana, alpha, keyword）を消さないための処理
        $bands->appends($request->query());

        return view('bands.index', compact('bands'));
    }


    public function show(\App\Models\Band $band)
    {
        return view('bands.show', compact('band'));
    }


    public function create()
    {
        return view('bands.create');
    }


    public function store(Request $request)
    {
        // 1. バリデーション（結果を変数に入れる）
        $validated = $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255',
            'genre' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. YouTubeの空の入力欄を除外
        $urls = array_filter($request->input('youtube_urls', []));

        // 3. データを一旦すべて取得
        $data = $request->all();
        $data['youtube_urls'] = array_values($urls);

        // 4. 画像の処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('bands', 'public');
            $data['image_path'] = $path;
        }

        // 5. データベースに保存（$validated ではなく、加工済みの $data を渡す）
        // $request->user()->bands() を使うことで、自動的に user_id がセットされます
        $request->user()->bands()->create($data);

        return redirect()->route('bands.index')->with('status', 'バンドを登録しました！');
    }


    // 編集画面を表示
        public function edit(\App\Models\Band $band)
    {
        // 権限がない場合は 403 Forbidden エラーを出す
        $this->authorize('update', $band);

        return view('bands.edit', compact('band'));
    }

    // データを更新
    public function update(Request $request, Band $band)
    {
        // dd($band);
        // 1. バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // ...他...
        ]);

        // 2. データを取得
        $data = $request->all();

        // 3. YouTubeの空入力を除外してセット
        $urls = array_filter($request->input('youtube_urls', []));
        $data['youtube_urls'] = array_values($urls); 

        // 4. 画像の更新処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('bands', 'public');
            $data['image_path'] = $path;
        }

        // 5. 更新（$fillableにyoutube_urlsがあればこれでOK）
        $band->update($data);

        return redirect()->route('bands.show', $band);//[ => $band->id])->with('status', '更新しました');
    }

    
    public function destroy(\App\Models\Band $band)
    {
        // 1. データを取得
        $band = Band::findOrFail($id);

        // 2. 削除実行
        $band->delete();

        // 3. 一覧画面に戻る
        return redirect()->route('bands.index')->with('status', 'バンドを削除しました');
    }
}

