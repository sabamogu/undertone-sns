<?php

namespace App\Http\Controllers;

use App\Models\Band; //Bandモデルを使う宣言
use Illuminate\Http\Request;

class BandController extends Controller
{
    public function index(Request $request)
    {
        // 1. まず「クエリ（命令）」の準備をする（まだ実行はしない）
        $query = Band::query();

        // 2. もしURLに「kana=あ」のような指定があったら、その行で絞り込む
        if ($request->has('kana')) {
            $row = $request->input('kana');
        
            // 50音の各行に対応する正規表現
            $patterns = [
                'あ' => '^[あいうえおアィイゥウェエォオ]',
                'か' => '^[かきくけこカキクケコガギグゲゴ]',
                'さ' => '^[さしすせそサシスセソザジズゼゾ]',
                'た' => '^[たちつてとタチツテトダヂヅデド]',
                'な' => '^[なにぬねのナニヌネノ]',
                'は' => '^[はひふへほハヒフヘホバビブベボパピプペポ]',
                'ま' => '^[まみむめもマミムメモ]',
                'や' => '^[やゆよヤユヨ]',
                'ら' => '^[らりるれろラリルレロ]',
                'わ' => '^[わをんワヲン]',
            ];

            if (isset($patterns[$row])) {
                // name_kanaカラムが、指定した行の文字で始まっているものを探す
                $query->where('name_kana', 'REGEXP', $patterns[$row]);
            }
        }

        // 3. もしURLに「alpha=A」のような指定があったら、その文字で絞り込む
        if ($request->has('alpha')) {
            $char = $request->input('alpha');
            $query->where('name', 'like', $char . '%');
        }

        // 4. 最後にデータを取得（最新順に並べるおまけ付き）
        $bands = $query->orderBy('name_kana', 'asc')->get();

        // 5. 画面に渡す
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

