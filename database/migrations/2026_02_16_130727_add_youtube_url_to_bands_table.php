<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bands', function (Blueprint $table) {
            // もし youtube_url（単数）が存在するなら、youtube_urls（複数）に名前変更
            if (Schema::hasColumn('bands', 'youtube_url')) {
                $table->renameColumn('youtube_url', 'youtube_urls');
            } else {
                // 存在しない場合は新規作成（念のため）
                $table->json('youtube_urls')->nullable()->after('area');
            }
        });

        // 既存データの型チェックと移行（もし必要なら）
        $bands = DB::table('bands')->get();
        foreach ($bands as $band) {
            // もし中身が ["ID"] という形式の文字列になっていれば、そのままJSONとして解釈されますが、
            // 単なる ID だった場合は JSON 形式にラップし直す必要があります。
        }
    }
};
