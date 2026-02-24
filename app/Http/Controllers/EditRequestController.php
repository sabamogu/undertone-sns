<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Band; 
use App\Models\EditRequest; 

class EditRequestController extends Controller
{
    public function store(Request $request, Band $band)
    {
        // 全ての項目をバリデーション（BandControllerと合わせる）
        $validated = $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255',
            'genre' => 'nullable',
            'description' => 'nullable',
            'area' => 'nullable|max:255',
            'formation' => 'nullable|max:255',
            'label' => 'nullable|max:255',
            'formed_at' => 'nullable|date',
        ]);

        $urls = array_filter($request->input('youtube_urls', []));

        // 保存処理（EditRequestモデルのfillableに項目が追加されているか確認してください）
        EditRequest::create([
            'band_id' => $band->id,
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'name_kana' => $validated['name_kana'],
            'genre' => $validated['genre'],
            'description' => $validated['description'] ?? '',
            // 他の項目も必要ならテーブルにカラムを追加してここに入れる
            'area' => $validated['area'],           
            'formation' => $validated['formation'], 
            'label' => $validated['label'],         
            'formed_at' => $validated['formed_at'], 
            'youtube_urls' => array_values(array_filter($request->input('youtube_urls', []))),
            'status' => 'pending', 
        ]);

        return redirect()->route('bands.show', $band)->with('status', '編集提案を送信しました！投稿者が承認すると反映されます。');
    }

    public function index(Band $band)
    {
        $requests = $band->editRequests()->where('status', 'pending')->with('user')->get();
        return view('bands.edit-requests.index', compact('band', 'requests'));
    }

    public function approve(EditRequest $editRequest)
    {
        $band = $editRequest->band;

        // 提案された内容でバンド情報を上書き！
        $band->update([
            'name' => $editRequest->name,
            'name_kana' => $editRequest->name_kana,
            'genre' => $editRequest->genre,
            'description' => $editRequest->description,
            'area' => $editRequest->area,           
            'formation' => $editRequest->formation, 
            'label' => $editRequest->label, 
            'formed_at' => $editRequest->formed_at, 
            'youtube_urls' => $editRequest->youtube_urls,

        ]);

        // 提案のステータスを「承認済み」に変更
        $editRequest->update(['status' => 'approved']);

        return redirect()->route('bands.show', $band)->with('status', '提案を承認し、情報を更新しました！');
    }

    public function reject(EditRequest $editRequest)
    {
        // ステータスを「却下(rejected)」に変更する
        $editRequest->update(['status' => 'rejected']);

        return redirect()->route('bands.show', $editRequest->band)->with('status', '提案を却下しました。');
    }
}
