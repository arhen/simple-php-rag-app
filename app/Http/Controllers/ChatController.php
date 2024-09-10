<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RagService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ChatController extends Controller
{
    private $ragService;

    public function __construct(RagService $ragService)
    {
        $this->ragService = $ragService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'chat' => 'required|array',
        ]);

        $chat = $request->input('chat');

        try {
            $response = $this->ragService->answerQuestion($chat, $request->user());
            return Inertia::render('Chat', ['response' => $response]);
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withErrors(['message' => 'An error occurred. Please try again.']);
        }
    }
}
