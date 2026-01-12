<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelegramUser;
use App\Models\TelegramChat;
use App\Models\TelegramMessage;

class TelegramWebhookController extends Controller{
    public function handle(Request $request){
        $data = $request->all();

        $userData = $data['message']['from'];
        $chatData = $data['message']['chat'];
        $text = $data['message']['text'] ?? '';

        $user = TelegramUser::updateOrCreate(
            ['telegram_user_id' => $userData['id']],
            ['first_name'] => $userData['first_name'] ?? null]
        );

        $chat = TelegramChat::updateOrCreate(
            ['telegram_chat_id' => $chatData['id']],
            ['name' => $chatData['title'] ?? $userData['first_name'], 'type' => $chatData['type']]
        );

        TelegramMessage::create([
            'telegram_chat_id' => $chat->id,
            'telegram_user_id' => $user->id,
            'telegram_message_id' => $data['message']['message_id'],
            'direction' => 'incoming',
            'type' => 'text',
            'text' => $text,
            'is_read' => false,
            'telegram_date' => now(),
        ]);

        return response('ok');
    }
}
