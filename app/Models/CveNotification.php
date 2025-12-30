<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CveNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cve_query_id',
        'cve_id',
        'cve_data',
        'notified_emails',
        'notified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cve_data' => 'array',
            'notified_emails' => 'array',
            'notified_at' => 'datetime',
        ];
    }

    /**
     * Get the CVE query that owns this notification.
     */
    public function cveQuery(): BelongsTo
    {
        return $this->belongsTo(CveQuery::class);
    }
}
