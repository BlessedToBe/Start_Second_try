<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
        'telegram_chat_id',
        'telegram_user_id',
        'telegram_message_id',
        'direction',
        'type',
        'text',
        'file_id',
        'is_read',
        'telegram_date',
    ];

    protected $casts = [
        'telegram_date' => 'datetime',
        'is_read' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(TelegramUser::class, 'telegram_user_id');
    }

    public function chat(){
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id');
    }

    public function isFromUser(){
        return $this->direction === 'incoming';
    }

    public function isFromOperator(){
        return $this->direction === 'outgoing';
    }

    public function getFileUrl(){
        if(!$this->file_id){
            return null;
        }

        $token = env('TELEGRAM_BOT_TOKEN');
        return "https://api.telegram.org/file/bot{$token}/{$this->file_id}";
    }
}
