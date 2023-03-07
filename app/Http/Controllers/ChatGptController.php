<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ChatGptController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/Index');
    }

    public function ask(Request $request)
    {
        $response = $this->askToChatGPT($request->input('prompt'), $request->input('temperature'));

        return $response->json();
    }

    private function askToChatGPT($prompt, $temperature = 0.5)
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer '.env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/engines/text-davinci-003/completions', [
                'prompt' => $prompt,
                'max_tokens' => 1000,
                'temperature' => intval($temperature),
            ]);

        if (! $response->successful()) {
            dd($response);
        }

        return $response;
    }
}
