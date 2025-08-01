<?php

namespace App\Http\Controllers;

use App\Models\Campaing;
use App\Models\CampaignUrl;
use Illuminate\Http\Request;
use SimpleXMLElement;

class IndexerController extends Controller
{
    public function index()
    {

        $campaigns = Campaing::with('urls')->paginate(10);
        return view('indexer.index', compact('campaigns'));
    }

    // public function show($data)
    // {
    //     return view('indexer.form',compact('data'));
    // }

    public function processSitemap(Request $request)
    {
        $request->validate([
            'sitemap_url' => 'required|url'
        ]);

        $sitemapUrl = $request->input('sitemap_url');

        try {
            // Check if the URL is accessible
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10 // set a timeout to avoid hanging
                ]
            ]);

            $xml = @file_get_contents($sitemapUrl, false, $context);

            if ($xml === false) {
                // If file_get_contents fails, throw an exception
                $error = error_get_last();
                throw new \Exception("Failed to access sitemap: " . ($error['message'] ?? 'Unknown error'));
            }

            // Try to parse the XML
            try {
                $sitemap = new SimpleXMLElement($xml);
            } catch (\Exception $e) {
                throw new \Exception("Invalid XML format: " . $e->getMessage());
            }

            // Continue with the rest of your code
            $result = $this->analyzeSitemapStructure($sitemapUrl);

            // Organizar las URLs por sitemap para la vista
            $organizedUrls = [];
            foreach ($result['sitemaps'] as $sitemap) {
                $organizedUrls[$sitemap] = [
                    'blog_urls' => array_filter($result['blog_urls'], function ($item) use ($sitemap) {
                        return $item['source_sitemap'] === $sitemap;
                    }),
                    'other_urls' => array_filter($result['other_urls'], function ($item) use ($sitemap) {
                        return $item['source_sitemap'] === $sitemap;
                    })
                ];
            }

            return view('indexer.show', [
                'sitemap_url' => $sitemapUrl,
                'is_index' => $result['is_index'],
                'sitemaps' => $result['sitemaps'],
                'organized_urls' => $organizedUrls,
                'total_blog_urls' => count($result['blog_urls']),
                'total_other_urls' => count($result['other_urls'])
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error processing sitemap: ' . $e->getMessage());
        }
    }


    public function submitCampaña(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'sitemap_url' => 'required|url',
            'selected_urls' => 'required|array',
            'selected_urls.*' => 'url'
        ]);

        $campaignName = $request->input('campaign_name');
        $sitemapUrl = $request->input('sitemap_url');
        $selectedUrls = $request->input('selected_urls');
        try {
            // Utilizamos el servicio para enviar las URLs a la API externa
             $urlSubmissionService = new \App\Services\UrlSubmissionService();
             $result = $urlSubmissionService->submitUrls($selectedUrls, $campaignName);

            
            $campaign = Campaing::create([
                'name' => $campaignName,
                'sitemap_url' => $sitemapUrl,
                'urls_count' => count($selectedUrls),
                'status' => $result['status'],
                'report_url' => $result['status'] === 'success' ? $result['report_url'] : null
            ]);

            // Guardamos las URLs individuales asociadas a la campaña
            foreach ($selectedUrls as $url) {
                CampaignUrl::create([
                    'campaign_id' => $campaign->id,
                    'url' => $url,
                    'status' => 'pending',
                    'indexed_at' => null
                ]);
            }
            if ($result['status'] === 'success') {
                return redirect()->route('indexer.index')
                    ->with('success', 'Campaign "' . $campaignName . '" successfully created with ' . count($selectedUrls) . ' URLs to index. Report available at: ' . $result['report_url']);
            } else {
                return redirect()->route('indexer.index')
                    ->with('error', 'Error submitting the campaign: ' . $result['message']);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error processing the indexing campaign: ' . $e->getMessage());

            return redirect()->route('indexer.index')
                ->with('error', 'Error processing the campaign: ' . $e->getMessage());
        }
    }

    private function analyzeSitemapStructure($sitemapUrl)
    {
        $xml = file_get_contents($sitemapUrl);
        $sitemap = new SimpleXMLElement($xml);

        $result = [
            'is_index' => false,
            'sitemaps' => [],
            'blog_urls' => [],
            'other_urls' => []
        ];

        // Si es un índice de sitemaps
        if (isset($sitemap->sitemap)) {
            $result['is_index'] = true;

            foreach ($sitemap->sitemap as $sitemapElement) {
                if (isset($sitemapElement->loc)) {
                    $subSitemapUrl = (string)$sitemapElement->loc;
                    $result['sitemaps'][] = $subSitemapUrl;

                    // Procesar cada sub-sitemap
                    $subResult = $this->processSingleSitemap($subSitemapUrl);
                    $result['blog_urls'] = array_merge($result['blog_urls'], $subResult['blog_urls']);
                    $result['other_urls'] = array_merge($result['other_urls'], $subResult['other_urls']);
                }
            }
        } else {
            // Si es un sitemap normal
            $result['sitemaps'][] = $sitemapUrl;
            $subResult = $this->processSingleSitemap($sitemapUrl);
            $result['blog_urls'] = $subResult['blog_urls'];
            $result['other_urls'] = $subResult['other_urls'];
        }

        return $result;
    }

    private function processSingleSitemap($sitemapUrl)
    {
        $xml = file_get_contents($sitemapUrl);
        $sitemap = new SimpleXMLElement($xml);

        $result = [
            'blog_urls' => [],
            'other_urls' => []
        ];

        foreach ($sitemap->url as $urlElement) {
            if (isset($urlElement->loc)) {
                $url = (string)$urlElement->loc;
                $lastmod = isset($urlElement->lastmod) ? (string)$urlElement->lastmod : null;

                $urlData = [
                    'url' => $url,
                    'lastmod' => $lastmod,
                    'source_sitemap' => $sitemapUrl
                ];

                if ($this->isBlogUrl($url)) {
                    $result['blog_urls'][] = $urlData;
                } else {
                    $result['other_urls'][] = $urlData;
                }
            }
        }

        return $result;
    }

    private function isBlogUrl($url)
    {
        // Patrones para identificar URLs de blog
        $blogPatterns = [
            '/\/blog\//',
            '/\/post\//',
            '/\/article\//',
            '/\/news\//',
            '/\/[0-9]{4}\/[0-9]{2}\/[0-9]{2}\//' // Estructura de fecha en la URL
        ];

        foreach ($blogPatterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        return false;
    }
}
