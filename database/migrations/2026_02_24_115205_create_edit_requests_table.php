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
        Schema::create('edit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('band_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 提案される新しいデータ
            $table->string('name');
            $table->string('name_kana');
            $table->string('genre')->nullable();
            $table->text('description')->nullable();
            $table->string('area')->nullable();
            $table->string('formation')->nullable();
            $table->string('label')->nullable();
            $table->date('formed_at')->nullable();
            $table->json('youtube_urls')->nullable(); // 配列で保存
            
            // 承認状態（pending: 保留, approved: 承認, rejected: 却下）
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_requests');
    }
};
