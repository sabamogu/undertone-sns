<?php

namespace App\Http\Controllers;

use App\Models\Band; //Bandモデルを使う宣言
use Illuminate\Http\Request;

class BandController extends Controller
{

    public function index(Request $request)
    {
        $query = Band::query();

        // 2. キーワード検索（セレクトボックス導入に合わせたシンプル版）
        if ($request->filled('keyword')) {
            $input = $request->input('keyword');

            // 【修正】mb_convert_kana は「全角・半角の差」を埋めるために残すと親切です
            $keywords = [
                $input,
                mb_convert_kana($input, "KVC"), // 全角カタカナ
                mb_convert_kana($input, "r"),   // 半角英数字(rock)
            ];

            // 【追加】もし入力が「ロック」なら「Rock」も検索対象に加える
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

        // 3. 50音検索（ここは変更なし）
        if ($request->filled('kana')) {
            // ...既存のコード...
        }

        // 4. アルファベット検索（ここは変更なし）
        if ($request->filled('alpha')) {
            // ...既存のコード...
        }

        $bands = $query->orderBy('name_kana', 'asc')->get();
        return view('bands.index', compact('bands'));
    }

    public function show($id)
    {
        // IDを元に、そのバンド1件だけを取得。なければ404エラーを出す
        $band = Band::findOrFail($id);

        return view('bands.show', compact('band'));
    }


    public function create()
    {
        return view('bands.create');
    }

    public function store(Request $request)
    {
        // 1. すべての入力チェック（バリデーション）をまとめて行う
        $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255',
            'genre' => 'nullable',
            'youtube_url' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のチェックを追加
        ]);

        // 2. 入力データをすべて取得して変数 $data に入れる
        $data = $request->all();

        // 3. 画像がアップロードされた場合だけの特別処理
        if ($request->hasFile('image')) {
            // 画像ファイルを保存し、その保存先パス（bands/xxxx.jpg）を取得
            $path = $request->file('image')->store('bands', 'public');
            
            // 保存用データの中に、画像のパスを書き加える
            $data['image_path'] = $path;
        }

        // 4. まとめてデータベースに保存（ここで1回だけ実行！）
        Band::create($data);

        // 5. 最後に1回だけ一覧画面へリダイレクト
        return redirect()->route('bands.index')->with('status', 'バンドを登録しました！');
    }


    // 編集画面を表示
        public function edit($id)
    {
        $band = Band::findOrFail($id);
        return view('bands.edit', compact('band'));
    }

    // データを更新
    public function update(Request $request, $id)
    {
        // 1. バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. データを取得して更新
        $band = Band::findOrFail($id);
        $data = $request->all();

        // 画像が新しくアップロードされた場合の処理
        if ($request->hasFile('image')) {
            // もし古い画像があれば削除する
            if ($band->image_path) {
                \Storage::disk('public')->delete($band->image_path);
            }
            // 新しい画像を保存
            $path = $request->file('image')->store('bands', 'public');
            $data['image_path'] = $path;
        }

        $band->update($data);

        // 3. 詳細画面に戻る
        return redirect()->route('bands.show', $band->id)->with('status', '情報を更新しました！');
    }

    
    public function destroy($id)
    {
    // 1. データを取得
    $band = Band::findOrFail($id);

    // 2. 削除実行
    $band->delete();

    // 3. 一覧画面に戻る
    return redirect()->route('bands.index')->with('status', 'バンドを削除しました');
    }
}

