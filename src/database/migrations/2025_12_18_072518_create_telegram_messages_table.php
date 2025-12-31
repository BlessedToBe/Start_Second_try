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
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telegram_chat_id')->constrained('telegram_chats')->onDelete('cascade');
            $table->bigInteger('telegram_message_id');
            $table->enum('direction', ['incoming', 'outgoing'])->default('incoming');
            $table->enum('type', ['text', 'photo', 'document'])->default('text');
            $table->text('text')->nullable();
            $table->string('file_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('telegram_date')->nullable();
            $table->timestamps();

            $table->index('telegram_message_id');
            $table->index('direction');
            $table->index('type');
            $table->index('is_read');
            $table->index(['telegram_chat_id', 'created_at']);

            $table->unique(['telegram_chat_id', 'telegram_message_id'], 'chat_message_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
