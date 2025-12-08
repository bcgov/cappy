<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ministry',
        'division',
        'business_owner_name',
        'business_owner_email',
        'technical_contact_name',
        'technical_contact_email',
        'description',
        'status',
        'hosting_type',
        'hosting_details',
        'documentation_url',
        'repository_url',
        'go_live_date',
        'end_of_life_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'go_live_date' => 'date:Y-m-d',
        'end_of_life_date' => 'date:Y-m-d',
        'deleted_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'active',
    ];

    /**
     * Get the status options for the application.
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'decommissioned' => 'Decommissioned',
            'in_development' => 'In Development',
        ];
    }

    /**
     * Get the hosting type options for the application.
     *
     * @return array
     */
    public static function getHostingTypeOptions(): array
    {
        return [
            'on_premise' => 'On-Premise',
            'cloud' => 'Cloud',
            'hybrid' => 'Hybrid',
            'saas' => 'SaaS',
        ];
    }
}
