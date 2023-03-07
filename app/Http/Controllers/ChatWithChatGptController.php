<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ChatWithChatGptController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/Index');
    }

    public function chat(Request $request)
    {
        $response = $this->chatWithChatGPT($request->input('messages'));

        return $response->json();
    }

    private function chatWithChatGPT($messages = [])
    {
        $messages = array_merge([[
            'role' => 'system',
            'content' => 'be a helpful music expert',
        ]], $messages);

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer '.env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

        if (! $response->successful()) {
            dd($response);
        }

        return $response;
    }
}
