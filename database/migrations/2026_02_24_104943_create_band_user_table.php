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
        Schema::create('band_user', function (Blueprint $table) {
            $table->id();
            // ユーザーID（お気に入りした人）
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // バンドID（お気に入りされたバンド）
            $table->foreignId('band_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 同じ人が同じバンドを二重にお気に入りできないようにする
            $table->unique(['user_id', 'band_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('band_user');
    }
};
