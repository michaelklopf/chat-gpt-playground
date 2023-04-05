<?php

use App\Http\Controllers\ChatGptController;
use App\Http\Controllers\ChatWithChatGptController;
use App\Http\Controllers\EditWithChatGptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/ask', [ChatGptController::class, 'index'])
    ->name('ask.index');
Route::post('/chatgpt/ask', [ChatGptController::class, 'ask'])
    ->name('chatgpt.ask');

Route::get('/chat', [ChatWithChatGptController::class, 'index'])
    ->name('chat.index');
Route::post('/chatgpt/chat', [ChatWithChatGptController::class, 'chat'])
    ->name('chatgpt.chat');

Route::get('/edit', [EditWithChatGptController::class, 'index'])
    ->name('edit.index');
Route::post('/chatgpt/edit', [EditWithChatGptController::class, 'edit'])
    ->name('chatgpt.edit');
