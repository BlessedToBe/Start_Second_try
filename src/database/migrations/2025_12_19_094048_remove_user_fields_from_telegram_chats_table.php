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
        Schema::table('telegram_chats', function (Blueprint $table) {
            $table->dropColumn(['telegram_user_id', 'username', 'first_name']);

            $table->renameColumn('title', 'name');

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telegram_chats', function (Blueprint $table) {
            $table->bigInteger('telegram_user_id')->nullable()->after('telegram_chat_id');
            $table->string('username')->nullable()->after('telegram_user_id');
            $table->string('first_name')->nullable()->after('username');

            $table->renameColumn('name', 'title');

            $table->dropIndex(['name']);
            $table->index('title');
            $table->index('telegram_user_id');
        });
    }
};
