<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt;
use Illuminate\Support\Facades\Auth;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prompts = Prompt::where('user_id', Auth::id())
            ->orderBy('is_favorite', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($prompts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100'
        ]);

        $prompt = Prompt::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category ?? 'general',
            'user_id' => Auth::id()
        ]);

        return response()->json($prompt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prompt = Prompt::where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($prompt);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_favorite' => 'boolean'
        ]);

        $prompt = Prompt::where('user_id', Auth::id())
            ->findOrFail($id);

        $prompt->update($request->only(['title', 'content', 'category', 'is_favorite']));

        return response()->json($prompt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prompt = Prompt::where('user_id', Auth::id())
            ->findOrFail($id);

        $prompt->delete();

        return response()->json(['message' => 'Prompt deleted successfully']);
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite(string $id)
    {
        $prompt = Prompt::where('user_id', Auth::id())
            ->findOrFail($id);

        $prompt->update(['is_favorite' => !$prompt->is_favorite]);

        return response()->json($prompt);
    }
}
