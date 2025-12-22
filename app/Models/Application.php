<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Application extends Model
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
        'category',
        'average_daily_users',
        'annual_cost',
        'cost_function',
        'cost_per_unit',
        'license_summary',
        'annual_vendor_cost',
        'initial_deployment',
        'end_of_support',
        'end_of_life',
        'disposition_deadline',
        'disposition_decision',
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
            'initial_deployment' => 'date',
            'end_of_support' => 'date',
            'end_of_life' => 'date',
            'disposition_deadline' => 'date',
        ];
    }

    public function applicationUsers(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationUserType::class,
        'application_users',
        'application_id',
        'application_user_type_id')
        ->withPivot('description');
    }



    public function businessAreas(): HasManyThrough
    {
        return $this->hasManyThrough(BusinessArea::class,
        ApplicationUserType::class,
        'application_id',
        'business_area_id');
    }

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'components',
        'application_id',
        'component_of_id')
        ->withPivot('description');
    }

    public function component_of(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'components',
        'component_of_id',
        'application_id')
        ->withPivot('description');
    }
    

    public function dependencies(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'dependencies',
        'depending_application_id',
        'supporting_application_id')
        ->withPivot('description');
    }

    public function dependency_of(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'dependencies',
        'supporting_application_id',
        'depending_application_id')
        ->withPivot('description');
    }

    public function documentation(): BelongsToMany
    {
        return $this->belongsToMany(Documentation::class,
        'application_documentation',
        'application_id',
        'documentation_id')
        ->withPivot('description');
    }

    public function integrations(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'integrations',
        'application_id',
        'integrates_with_id')
        ->withPivot('description','protocol','direction','frequency','security');
    }

    public function staffing(): BelongsToMany
    {
        return $this->belongsToMany(STOB50::class,
        'staffing',
        'application_id',
        'stob50_id')
        ->withPivot('description');
    }

    public function subjectMatterExperts(): BelongsToMany
    {
        return $this->belongsToMany(SubjectMatterExpert::class,
        'application_subject_matter_expert',
        'application_id',
        'subject_matter_expert_id')
        ->withPivot('description');
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class,
        'vendor_relationships',
        'application_id',
        'vendor_id')
        ->withPivot('description', 'contract_id');
    }

    public function vendorSupports(): BelongsToMany
    {
        return $this->belongsToMany(STOB60::class,
        'vendor_supports',
        'application_id',
        'stob60_id')
        ->withPivot('description');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ApplicationVersion::class);
    }




}
