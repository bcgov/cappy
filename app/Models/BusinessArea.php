<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BusinessArea extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
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

    public function applications(): HasManyThrough
    {
        return $this->hasManyThrough(Application::class,
        ApplicationUserType::class,
        'business_area_id',
        'application_id');
    }

    public function userTypes(): HasMany
    {
        return $this->hasMany(ApplicationUserType::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BusinessArea::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(BusinessArea::class, 'parent_business_area_id', 'id');
    }

    public function subjectMatterExperts(): MorphMany
    {
        return $this->morphMany(SubjectMatterExpert::class, 'affiliable');
    }
}
