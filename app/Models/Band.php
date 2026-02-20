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
        'youtube_url',
        'image_path',
    ];
    // ジャンルのリストを定義（DBに保存する値 => 画面に表示する名前）
    public static $genres = [
        'Rock' => 'ロック(Rock)',
        'Punk' => 'パンク(Punk)',
        'Jazz' => 'ジャズ(Jazz)',
        'Pop'  => 'ポップ(Pop)',
        'Metal' => 'メタル(Metal)',
        'HipHop' => 'ヒップホップ(HipHop)',
        'Others' => 'その他(Others)'
    ];
}
