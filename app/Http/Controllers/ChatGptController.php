<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGptController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/Index');
    }

    public function ask(Request $request)
    {
        $prompt = $request->input('prompt');
        $response = $this->askToChatGPT($prompt);
        return $response->json();
        // return view('chatgpt.response', ['response' => $response]);
    }

    private function askToChatGPT($prompt)
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/engines/text-davinci-003/completions', [
                "prompt" => $prompt,
                "max_tokens" => 1000,
                "temperature" => 0.5
            ]);

        if (! $response->successful()) {
            dd($response);
        }

        return $response;
    }
}
