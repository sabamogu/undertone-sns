<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditRequest extends Model
{
    protected $fillable = 
    [
        'band_id',
        'user_id',
        'name',
        'name_kana',
        'genre', 
        'description',
        'area',
        'formation',
        'label',
        'formed_at',
        'youtube_urls',
        'status'
    ];

    // データの取り出し時に自動で配列に変換するように設定
    protected $casts = [
        'youtube_urls' => 'array',
    ];

    public function band() { return $this->belongsTo(Band::class); }
    public function user() { return $this->belongsTo(User::class); }
}
