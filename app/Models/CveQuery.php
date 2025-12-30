<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CveQuery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'search',
        'vendor',
        'product',
        'weakness',
        'tag',
        'cvss_threshold',
        'notification_emails',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'notification_emails' => 'array',
            'cvss_threshold' => 'decimal:1',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the applications that use this CVE query.
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_cve_query')
            ->withPivot('description')
            ->withTimestamps();
    }

    /**
     * Get the notifications for this CVE query.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(CveNotification::class);
    }

    /**
     * Check if a CVE has already been notified for this query.
     *
     * @param string $cveId
     * @return bool
     */
    public function hasNotifiedCve(string $cveId): bool
    {
        return $this->notifications()
            ->where('cve_id', $cveId)
            ->exists();
    }
}
