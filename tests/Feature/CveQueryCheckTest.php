<?php

namespace Tests\Feature;

use App\Models\CveQuery;
use App\Jobs\CheckCveQueriesJob;
use App\Services\OpenCveService;
use App\Notifications\NewCveNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CveQueryCheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_processes_active_queries(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-12345',
                        'title' => 'Test Vulnerability',
                        'summary' => 'A test CVE',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 8.5,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.0,
            'notification_emails' => ['test@example.com'],
            'is_active' => true,
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert notification was created
        $this->assertDatabaseHas('cve_notifications', [
            'cve_query_id' => $query->id,
            'cve_id' => 'CVE-2024-12345',
        ]);

        // Assert email was sent
        Notification::assertSentTimes(NewCveNotification::class, 1);
    }

    public function test_job_skips_cves_below_threshold(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-00001',
                        'title' => 'Low Severity CVE',
                        'summary' => 'A low severity CVE',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 5.0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.0,
            'is_active' => true,
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert no notification created
        $this->assertDatabaseMissing('cve_notifications', [
            'cve_id' => 'CVE-2024-00001',
        ]);

        // Assert no email was sent
        Notification::assertNothingSent();
    }

    public function test_job_handles_cve_exactly_at_threshold(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-77777',
                        'title' => 'Threshold CVE',
                        'summary' => 'A CVE exactly at threshold',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 7.5,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.5,
            'notification_emails' => ['test@example.com'],
            'is_active' => true,
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert notification was created (>= comparison)
        $this->assertDatabaseHas('cve_notifications', [
            'cve_query_id' => $query->id,
            'cve_id' => 'CVE-2024-77777',
        ]);
    }

    public function test_job_skips_inactive_queries(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-99999',
                        'title' => 'Test',
                        'summary' => 'Test',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 9.0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->inactive()->create([
            'cvss_threshold' => 7.0,
            'notification_emails' => ['test@example.com'],
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert no notification was created
        $this->assertDatabaseMissing('cve_notifications', [
            'cve_id' => 'CVE-2024-99999',
        ]);

        // Assert no email was sent
        Notification::assertNothingSent();
    }

    public function test_job_prevents_duplicate_notifications(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-55555',
                        'title' => 'Duplicate Test',
                        'summary' => 'Testing deduplication',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 8.0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.0,
            'notification_emails' => ['test@example.com'],
            'is_active' => true,
        ]);

        // Run job first time
        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert first notification created
        $this->assertDatabaseCount('cve_notifications', 1);
        Notification::assertSentTimes(NewCveNotification::class, 1);

        // Run job second time with same CVE
        $job2 = new CheckCveQueriesJob();
        $job2->handle(new OpenCveService());

        // Assert no duplicate notification created
        $this->assertDatabaseCount('cve_notifications', 1);
        // Still only 1 notification sent
        Notification::assertSentTimes(NewCveNotification::class, 1);
    }

    public function test_job_sends_to_multiple_email_addresses(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-88888',
                        'title' => 'Multi-email Test',
                        'summary' => 'Testing multiple recipients',
                        'metrics' => [
                            'cvssV3_1' => [
                                [
                                    'cvssData' => [
                                        'baseScore' => 8.2,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.0,
            'notification_emails' => ['user1@example.com', 'user2@example.com', 'user3@example.com'],
            'is_active' => true,
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert 3 notifications sent (one per email)
        Notification::assertSentTimes(NewCveNotification::class, 3);
    }

    public function test_job_skips_cves_without_cvss_score(): void
    {
        Http::fake([
            '*/cve*' => Http::response([
                'count' => 1,
                'next' => null,
                'previous' => null,
                'results' => [
                    [
                        'cve_id' => 'CVE-2024-11111',
                        'title' => 'No Score CVE',
                        'summary' => 'CVE without CVSS score',
                        'metrics' => [],
                    ],
                ],
            ], 200),
        ]);

        Notification::fake();

        $query = CveQuery::factory()->create([
            'cvss_threshold' => 7.0,
            'notification_emails' => ['test@example.com'],
            'is_active' => true,
        ]);

        $job = new CheckCveQueriesJob();
        $job->handle(new OpenCveService());

        // Assert no notification created (no score = skip)
        $this->assertDatabaseMissing('cve_notifications', [
            'cve_id' => 'CVE-2024-11111',
        ]);
    }
}
