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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // 顧客
            $table->foreignId('customer_id')
                ->constrained()
                ->restrictOnDelete();

            // 案件
            $table->string('title');
            $table->text('description')->nullable();

            // 案件ステータス
            $table->enum('status', [
                'estimating',   // 見積中
                'proposing',    // 提案中
                'contracted',   // 契約済
                'lost',         // 失注
                'on_hold',      // 保留
            ]);

            // 税抜金額
            $table->unsignedInteger('amount')->nullable();

            // 作業期間（プロジェクト期間）
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // 担当者
            $table->foreignId('assigned_user_id')
                ->constrained('users')
                ->restrictOnDelete();

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
        Schema::dropIfExists('projects');
    }
};
