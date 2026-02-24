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
            // usersテーブルのidと紐づく user_id を追加。
            // ユーザーが削除されたら、その人の投稿も消える（cascade）設定。
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bands', function (Blueprint $table) {
            Schema::table('bands', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // 制約を消す
            $table->dropColumn('user_id');    // 列を消す
        });
        });
    }
};
