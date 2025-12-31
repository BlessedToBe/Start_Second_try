<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'telegram_user_id',
        'username',
        'first_name'
    ];

    public function messages(){
        return $this->hasMany(TelegramMessage::class, 'telegram_user_id');
    }

}
