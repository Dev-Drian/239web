<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showHidden = $request->input('show_hidden', false);
        if ($showHidden) {
            $clients = Client::where('status', 'inactive')->paginate(10);
        } else {
            $clients = Client::where('status', 'active')->paginate(10);
        }
        return view('service.index', compact('clients', 'showHidden'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'client_ids' => 'array',
            'client_ids.*' => 'integer',
            'subscriptions' => 'array',
            'subscriptions.*' => 'array',
            'subscriptions.*.*' => 'in:seo,ppc,website,hosting,newsletter,crm',
        ]);

        $clientIds = $validated['client_ids'] ?? [];
        $payload = $validated['subscriptions'] ?? [];

        foreach ($clientIds as $clientId) {
            $client = Client::find($clientId);
            if (!$client) {
                continue;
            }
            $services = $payload[$clientId] ?? [];
            $normalized = array_values(array_unique(array_map('strtolower', $services)));
            $client->subscriptions = $normalized;
            $client->save();
        }

        return redirect()->route('service.index')->with('success', 'Services updated successfully.');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Cambia el estado de un cliente (active/inactive)
     */
    public function toggleStatus(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->status = $client->status === 'active' ? 'inactive' : 'active';
        $client->save();
        return response()->json(['success' => true, 'status' => $client->status]);
    }
}
