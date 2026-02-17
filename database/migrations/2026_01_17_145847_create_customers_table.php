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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // 担当者
            $table->string('name');
            $table->string('kana')->nullable();

            // 担当者情報
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // 会社情報
            $table->string('company_name')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();

            // 郵便番号・住所
            $table->string('postal_code', 7)->nullable();
            $table->string('address')->nullable();
            $table->string('address_detail')->nullable();

            // 顧客ステータス
            $table->enum('status', [
                'prospect',     // 見込み
                'negotiation',  // 商談中
                'won',          // 成約
                'lost',         // 失注
                'inactive',     // 休眠
            ]);

            // 顧客ランク
            $table->enum('rank', ['A', 'B', 'C'])
                ->default('C')
                ->nullable();

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
        Schema::dropIfExists('customers');
    }
};
