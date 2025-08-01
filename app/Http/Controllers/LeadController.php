<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function processLeads(Request $request)
    {
        $data = $request->json()->all();
        if (isset($data[0]) && is_array($data[0])) {
            // It's an array of objects
            foreach ($data as $lead) {
                $this->processLead($lead);
            }
        } else {
            // It's a single object
            $this->processLead($data);
        }

        return response()->json(['message' => 'Leads processed successfully']);
    }

    private function processLead($data)
    {
        // Check if the client already exists
        $client = Client::firstOrCreate(
            ['highlevel_id' => $data['highlevel_id']],
            ['highlevel_id' => $data['highlevel_id']]
        );

        // Insert lead associated with the client
        $lead = new Lead();
        $lead->client_id = $client->id;
        $lead->first_name = $data['first name'] ?? '';
        $lead->last_name = $data['last name'] ?? '';
        $lead->email = $data['email'] ?? '';
        $lead->phone = $data['phone'] ?? '';
        $lead->address = $data['address line 1'] ?? '';
        $lead->more = json_encode($data);
        $lead->save();

        Log::info('Lead inserted successfully: ' . $lead->id);
    }

    public function index()
    {
        $leads = Lead::with('client')->get();

        return view('leads.index', compact('leads'));
    }

    public function show($id)
    {
        $highlevelId = str_replace(' ', '', $id);

        if (empty($highlevelId)) {
            return response()->view('errors.custom', ['message' => 'Invalid client ID. Please verify the URL and try again.'], 400);
        }

        $client = Client::where('highlevel_id', $highlevelId)->first();

        if (!$client) {
            return response()->view('errors.custom', ['message' => 'Client not found. Please subscribe to CRM Limo at <a href="https://crm.limo.com" class="text-blue-500 underline">crm.limo</a>.'], 404);
        }

        if ($client->status !== 'active') {
            return response()->view('errors.custom', ['message' => 'The client does not have access.'], 403);
        }

        $leads = Lead::where('client_id', $client->id)->get();

        return view('leads.show', compact('leads'));
    }
}
