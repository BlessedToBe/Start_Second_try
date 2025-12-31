<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramChat extends Model
{
    protected $fillable = [
        'telegram_chat_id',
        'type',
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function messages(){
        return $this->hasMany(TelegramMessage::class, 'telegram_chat_id');
    }


    public function lastMessage(){
        return $this->hasOne(TelegramMessage::class, 'telegram_chat_id')->latest();
    }

    public function unreadCount(){
        return $this->messages()->where('is_read', false)->count();
    }

    public function isPrivate(){
        return $this->type === 'private';
    }

}

