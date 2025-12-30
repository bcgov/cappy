<?php

namespace App\Notifications;

use App\Models\CveQuery;
use App\Services\OpenCveService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCveNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private CveQuery $query,
        private array $cves
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("Cappy: {$this->query->name} - {$this->formatCveCount()} New CVE(s)")
            ->greeting("CVE Alert: {$this->query->name}")
            ->line("The following CVEs were detected matching your query criteria:");

        foreach ($this->cves as $cve) {
            $message->line($this->formatCve($cve));
        }

        // Add query details
        $message->line('')
            ->line('**Query Configuration:**')
            ->line("CVSS Threshold: {$this->query->cvss_threshold}+");

        if ($this->query->vendor) {
            $message->line("Vendor: {$this->query->vendor}");
        }
        if ($this->query->product) {
            $message->line("Product: {$this->query->product}");
        }
        if ($this->query->search) {
            $message->line("Search: {$this->query->search}");
        }

        // Add applications using this query
        $apps = $this->query->applications;
        if ($apps->isNotEmpty()) {
            $message->line('')
                ->line('**Associated Applications:**')
                ->line($apps->pluck('name')->join(', '));
        }

        $message->line('')
            ->line('This is an automated notification from Cappy Application Catalogue.');

        return $message;
    }

    /**
     * Format CVE count for subject line.
     */
    private function formatCveCount(): string
    {
        $count = count($this->cves);
        return $count === 1 ? '1' : (string) $count;
    }

    /**
     * Format a single CVE for email display.
     */
    private function formatCve(array $cve): string
    {
        $cveId = $cve['cve_id'] ?? $cve['id'] ?? 'Unknown';
        $title = $cve['title'] ?? 'No title';
        $description = $cve['summary'] ?? $cve['description'] ?? 'No description';

        // Extract CVSS score
        $cvssScore = $this->extractBestCvssScore($cve);
        $cvssText = $cvssScore ? " (CVSS: {$cvssScore})" : '';

        // Truncate description if too long
        if (strlen($description) > 200) {
            $description = substr($description, 0, 197) . '...';
        }

        return "**{$cveId}**{$cvssText}: {$title}\n{$description}\n";
    }

    /**
     * Extract best CVSS score from CVE metrics.
     */
    private function extractBestCvssScore(array $cve): ?string
    {
        $service = app(OpenCveService::class);
        $score = $service->extractCvssScore($cve);

        if ($score === null) {
            return null;
        }

        // Determine which version was used
        $metrics = $cve['metrics'] ?? [];
        $version = null;

        foreach (['cvssV4_0' => 'v4.0', 'cvssV3_1' => 'v3.1', 'cvssV3_0' => 'v3.0', 'cvssV2_0' => 'v2.0'] as $key => $label) {
            if (isset($metrics[$key][0]['cvssData']['baseScore'])) {
                $version = $label;
                break;
            }
        }

        return $version ? "{$score} ({$version})" : (string) $score;
    }
}
