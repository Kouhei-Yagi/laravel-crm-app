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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();

            // 顧客
            $table->foreignId('customer_id')
                ->constrained()
                ->nullOnDelete();

            // 案件
            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 担当者
            $table->foreignId('assigned_user_id')
                ->constrained('users')
                ->nullOnDelete();

            // 対応種別
            $table->enum('type', [
                'phone',    // 電話
                'email',    // メール
                'visit',    // 訪問
                'meeting',  // 打合せ
            ]);

            // 内容
            $table->text('content')->nullable();

            // 対応日時
            $table->dateTime('interacted_at');

            // メモ
            $table->text('memo')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
