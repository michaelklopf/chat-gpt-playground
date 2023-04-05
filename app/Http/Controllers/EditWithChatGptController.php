<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class EditWithChatGptController extends Controller
{
    public function index()
    {
        return Inertia::render('Edit/Index');
    }

    public function edit(Request $request)
    {
        $response = $this->editWithChatGPT($request->input('prompt'));

        return $response->json();
    }

    public function editWithChatGPT($prompt)
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer '.env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/edits', [
                'model' => 'text-davinci-edit-001',
                'input' => $prompt,
                'instruction' => 'Fix the spelling mistakes',
            ]);

        if (! $response->successful()) {
            dd($response);
        }

        return $response;
    }
}
