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
        Schema::create('telegram_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('telegram_chat_id')->unique();
            $table->bigInteger('telegram_user_id')->nullable();
            $table->string('type')->default('private');

            $table->string('username')->nullable();
            $table->string('first_name')->nullable();

            $table->string('title')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('telegram_chat_id');
            $table->index('telegram_user_id');
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_chats');
    }
};
