<?php

namespace Tests\Unit;

use App\Services\OpenCveService;
use Tests\TestCase;

class OpenCveServiceTest extends TestCase
{
    private OpenCveService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OpenCveService();
    }

    public function test_extract_cvss_score_from_v3_1(): void
    {
        $cveData = [
            'metrics' => [
                'cvssV3_1' => [
                    [
                        'cvssData' => [
                            'baseScore' => 7.5,
                            'vector' => 'CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:N/I:N/A:H',
                        ],
                    ],
                ],
            ],
        ];

        $score = $this->service->extractCvssScore($cveData);

        $this->assertEquals(7.5, $score);
    }

    public function test_extract_cvss_score_from_v4_0(): void
    {
        $cveData = [
            'metrics' => [
                'cvssV4_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 9.2,
                        ],
                    ],
                ],
            ],
        ];

        $score = $this->service->extractCvssScore($cveData);

        $this->assertEquals(9.2, $score);
    }

    public function test_extract_cvss_score_prioritizes_newer_version(): void
    {
        $cveData = [
            'metrics' => [
                'cvssV2_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 5.0,
                        ],
                    ],
                ],
                'cvssV3_1' => [
                    [
                        'cvssData' => [
                            'baseScore' => 7.5,
                        ],
                    ],
                ],
                'cvssV4_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 8.7,
                        ],
                    ],
                ],
            ],
        ];

        $score = $this->service->extractCvssScore($cveData);

        // Should return v4.0 score, not v3.1 or v2.0
        $this->assertEquals(8.7, $score);
    }

    public function test_extract_cvss_score_returns_null_when_no_metrics(): void
    {
        $cveData = ['metrics' => []];

        $score = $this->service->extractCvssScore($cveData);

        $this->assertNull($score);
    }

    public function test_extract_cvss_score_returns_null_when_metrics_missing(): void
    {
        $cveData = [];

        $score = $this->service->extractCvssScore($cveData);

        $this->assertNull($score);
    }

    public function test_extract_cvss_score_from_v3_0_when_v3_1_unavailable(): void
    {
        $cveData = [
            'metrics' => [
                'cvssV2_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 4.3,
                        ],
                    ],
                ],
                'cvssV3_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 6.8,
                        ],
                    ],
                ],
            ],
        ];

        $score = $this->service->extractCvssScore($cveData);

        // Should return v3.0 score since v4.0 and v3.1 are unavailable
        $this->assertEquals(6.8, $score);
    }

    public function test_extract_cvss_score_from_v2_0_as_fallback(): void
    {
        $cveData = [
            'metrics' => [
                'cvssV2_0' => [
                    [
                        'cvssData' => [
                            'baseScore' => 5.5,
                        ],
                    ],
                ],
            ],
        ];

        $score = $this->service->extractCvssScore($cveData);

        $this->assertEquals(5.5, $score);
    }
}
