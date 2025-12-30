<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class OpenCveService
{
    private string $baseUrl;
    private ?string $username;
    private ?string $password;

    public function __construct()
    {
        $this->baseUrl = config('services.opencve.base_url');
        $this->username = config('services.opencve.username');
        $this->password = config('services.opencve.password');
    }

    /**
     * Search CVEs using query parameters
     *
     * @param array $params Associative array of query parameters
     * @param int $page Page number for pagination
     * @return array Response with 'count', 'next', 'previous', 'results'
     * @throws RequestException
     */
    public function searchCves(array $params, int $page = 1): array
    {
        // Filter out null/empty parameters
        $queryParams = array_filter($params, fn($value) => !is_null($value) && $value !== '');
        $queryParams['page'] = $page;

        try {
            $request = Http::timeout(30)
                ->retry(3, 1000);

            // Add authentication if credentials are provided
            if ($this->username && $this->password) {
                $request = $request->withBasicAuth($this->username, $this->password);
            }

            $response = $request->get("{$this->baseUrl}/cve", $queryParams);

            $response->throw();  // Throw exception on 4xx/5xx

            return $response->json();
        } catch (RequestException $e) {
            Log::error('OpenCVE API request failed', [
                'params' => $queryParams,
                'status' => $e->response?->status(),
                'body' => $e->response?->body(),
            ]);
            throw $e;
        }
    }

    /**
     * Get CVE details by ID
     *
     * @param string $cveId
     * @return array|null
     */
    public function getCveById(string $cveId): ?array
    {
        try {
            $request = Http::timeout(30);

            // Add authentication if credentials are provided
            if ($this->username && $this->password) {
                $request = $request->withBasicAuth($this->username, $this->password);
            }

            $response = $request->get("{$this->baseUrl}/cve/{$cveId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (RequestException $e) {
            Log::error("Failed to fetch CVE {$cveId}", ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Extract highest CVSS score from CVE metrics
     * Checks v4.0, v3.1, v3.0, v2.0 in that order
     *
     * @param array $cveData
     * @return float|null
     */
    public function extractCvssScore(array $cveData): ?float
    {
        $metrics = $cveData['metrics'] ?? [];

        // Priority order: v4.0 > v3.1 > v3.0 > v2.0
        foreach (['cvssV4_0', 'cvssV3_1', 'cvssV3_0', 'cvssV2_0'] as $version) {
            if (isset($metrics[$version][0]['cvssData']['baseScore'])) {
                return (float) $metrics[$version][0]['cvssData']['baseScore'];
            }
        }

        return null;
    }

    /**
     * Fetch all results across pages for a query
     * Use with caution - can return many results
     *
     * @param array $params
     * @param int $maxPages
     * @return array
     */
    public function searchAllPages(array $params, int $maxPages = 10): array
    {
        $allResults = [];
        $page = 1;

        do {
            $response = $this->searchCves($params, $page);
            $allResults = array_merge($allResults, $response['results'] ?? []);

            $hasNext = !empty($response['next']);
            $page++;

            // Safety limit
            if ($page > $maxPages) {
                Log::warning('OpenCVE pagination limit reached', [
                    'params' => $params,
                    'max_pages' => $maxPages,
                ]);
                break;
            }
        } while ($hasNext);

        return $allResults;
    }
}
