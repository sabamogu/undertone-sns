<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    
    use HasFactory;

    protected $fillable =[
        'name',
        'name_kana',
        'genre',
        'formation',
        'label',
        'formed_at',
        'area',
        'youtube_urls',
        'image_path',
        'description',
        'user_id',
    ];
    // ジャンルのリストを定義（DBに保存する値 => 画面に表示する名前）
    public static $genres = [
        'Rock' => 'ロック(Rock)',
        'Punk' => 'パンク(Punk)',
        'Jazz' => 'ジャズ(Jazz)',
        'Pop'  => 'ポップ(Pop)',
        'Metal' => 'メタル(Metal)',
        'HipHop' => 'ヒップホップ(HipHop)',
        'Others' => 'その他(Others)',
    ];

    protected $casts = [
        'youtube_urls' => 'array',//保存時はjson、取得時は配列に自動変換
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}

    // すでにお気に入り済みか判定する便利なメソッドを追加しておきます
    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    public function editRequests() 
    {
         return $this->hasMany(EditRequest::class); 
    }
}
