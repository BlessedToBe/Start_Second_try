<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

use App\Http\Controllers\ChatController;

Route::get('/chats/{chat}', [ChatController::class, 'show']);
Route::post('/chats/{chat}/send', [ChatController::class, 'send']);
Route::get('/chats', [ChatController::class, 'index']);
Route::post('/telegram/webhook', function (){
    file_put_contents(
        storage_path('logs/telegram.txt'),
        json_encode(request()->all(), JSON_PRETTY_PRINT)
    );

    return 'ok';
});

