<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SubjectMatterExpert extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'affiliation_type',
        'affiliation_id',
        'email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'application_subject_matter_expert',
        'subject_matter_expert_id',
        'application_id')
        ->withPivot('description');
    }

    public function affiliable(): MorphTo
    {
        return $this->morphTo();
    }
}
