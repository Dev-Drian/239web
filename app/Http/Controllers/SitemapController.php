<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Client;
use App\Services\UrlSubmissionService;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    protected $urlSubmissionService;

    public function __construct(UrlSubmissionService $urlSubmissionService)
    {
        $this->urlSubmissionService = $urlSubmissionService;
    }

    public function submitUrls(Request $request, $id)
    {
        // Verify if the request is a POST


        // Find the client by highlevel_id
        $client = Client::where('highlevel_id', $id)->first();

        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' => 'Client not found.',
            ], 404);
        }

        // Read the request body (raw JSON)
        $input = $request->getContent();
        $data = json_decode($input, true);

        // Validate that required fields are present
        if (!isset($data['urls']) || !isset($data['campaign'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing required fields: "urls" and "campaign".',
            ], 400);
        }

        // Check if the blog post already exists
        $blog = Blog::where('posts', $data['urls'][0])->first();

        if ($blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'This blog post has already been indexed.',
            ], 409); // 409 Conflict
        }

        // Submit URLs using the service
        $response = $this->urlSubmissionService->submitUrls($data['urls'], $data['campaign']);

        // If the submission fails, return the error response
        if ($response['status'] !== 'success') {
            return response()->json([
                'status' => 'error',
                'message' => $response['message'],
            ], 400);
        }

        // Create a new blog entry
        $blog = Blog::create([
            'posts' => $data['urls'][0],
            'indexed' => true,
            'prsent' => $response['report_url'],
            'client_id' => $client->id,
            'date_created' => now(),
        ]);


        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Blog post submitted and indexed successfully.',
            'data' => [
                'blog' => $blog,
                'report_url' => $response['report_url'] ?? null,
            ],
        ], 200);
    }
}
