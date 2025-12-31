<?php

namespace App\Http\Controllers;

use App\Models\TelegramChat;
use App\Models\TelegramMessage;
use Illuminate\Http\Request;
use App\Services\TelegramService;

class ChatController extends Controller{
    public function show($chatId){
        $chat = TelegramChat::with('messages.user')->findOrFail($chatId);

        return view('chat.show', compact('chat'));
    }

    public function send(Request $request, $chatId, TelegramService $telegram){
        $chat = TelegramChat::findOrFail($chatId);

        $telegram->sendMessage(
            $chat->telegram_chat_id,
            $request->text
        );

        TelegramMessage::create([
            'telegram_chat_id' => $chatId,
            'telegram_message_id' => time(),
            'direction' => 'outgoing',
            'type' => 'text',
            'text' => $request->text,
            'is_read' => true,
        ]);

        return redirect()->back();
    }

    public function index(){
        $chats = TelegramChat::with(['messages' => function($q){
            $q->latest()->limit(1);
        }])->get();

        return view('chat.index', compact('chats'));
    }
}
