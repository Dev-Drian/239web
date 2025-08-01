<?php

namespace App\Http\Controllers;

use App\Services\GenerateContentService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $generateContentService;

    public function __construct(GenerateContentService $generateContentService)
    {
        $this->generateContentService = $generateContentService;
    }

    public function index()
    {
        return view('chat.index');
    }
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');

        if (empty($message)) {
            return response()->json(['error' => 'El mensaje no puede estar vacío'], 400);
        }

        $response = $this->generateContentService->generateContentGPTWithoutContext($message);

        return response()->json($response);
    }
}
