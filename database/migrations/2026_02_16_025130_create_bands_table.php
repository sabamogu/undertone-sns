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
        Schema::create('bands', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // バンド名
            $table->string('name_kana');             // バンド名（カナ）検索用
            $table->string('genre')->nullable();     // ジャンル
            $table->string('formation')->nullable(); // 編成（3ピース等）
            $table->string('label')->nullable();     // 所属レーベル
            $table->date('formed_at')->nullable();   // 結成年月日
            $table->string('area')->nullable();      // 活動地域
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bands');
    }
};
