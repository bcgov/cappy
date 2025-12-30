<?php

namespace App\Jobs;

use App\Models\CveQuery;
use App\Models\CveNotification;
use App\Services\OpenCveService;
use App\Notifications\NewCveNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckCveQueriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;  // 10 minutes
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(OpenCveService $opencve): void
    {
        $queries = CveQuery::where('is_active', true)->get();

        Log::info("Starting CVE check for {$queries->count()} active queries");

        foreach ($queries as $query) {
            try {
                $this->processQuery($query, $opencve);
            } catch (\Exception $e) {
                Log::error("Failed to process CVE query {$query->id}", [
                    'query_id' => $query->id,
                    'error' => $e->getMessage(),
                ]);
                // Continue to next query even if one fails
            }
        }

        Log::info("Completed CVE check");
    }

    /**
     * Process a single CVE query.
     */
    private function processQuery(CveQuery $query, OpenCveService $opencve): void
    {
        // Build query parameters from model
        $params = array_filter([
            'search' => $query->search,
            'vendor' => $query->vendor,
            'product' => $query->product,
            'weakness' => $query->weakness,
            'tag' => $query->tag,
        ]);

        // Fetch CVEs (limit to first 5 pages = 50 CVEs max per query)
        $cves = $opencve->searchAllPages($params, maxPages: 5);

        $newCves = [];

        foreach ($cves as $cveData) {
            $cveId = $cveData['cve_id'] ?? $cveData['id'] ?? null;

            if (!$cveId) {
                continue;
            }

            // Check if already notified
            if ($query->hasNotifiedCve($cveId)) {
                continue;
            }

            // Extract CVSS score
            $cvssScore = $opencve->extractCvssScore($cveData);

            // Skip if no score or below threshold
            if ($cvssScore === null || $cvssScore < $query->cvss_threshold) {
                continue;
            }

            // Record this CVE for notification
            $newCves[] = $cveData;

            // Create notification record
            CveNotification::create([
                'cve_query_id' => $query->id,
                'cve_id' => $cveId,
                'cve_data' => $cveData,
                'notified_emails' => $query->notification_emails,
                'notified_at' => now(),
            ]);
        }

        // Send notification if there are new CVEs
        if (!empty($newCves)) {
            $this->sendNotifications($query, $newCves);
        }

        Log::info("Processed CVE query {$query->id}", [
            'query_id' => $query->id,
            'total_cves' => count($cves),
            'new_cves' => count($newCves),
        ]);
    }

    /**
     * Send notifications to all email addresses for a query.
     */
    private function sendNotifications(CveQuery $query, array $cves): void
    {
        // Send to all email addresses in the query
        foreach ($query->notification_emails as $email) {
            try {
                Notification::route('mail', $email)
                    ->notify(new NewCveNotification($query, $cves));
            } catch (\Exception $e) {
                Log::error("Failed to send CVE notification", [
                    'query_id' => $query->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
