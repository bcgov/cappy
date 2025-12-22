<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApplicationUserType extends Model
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

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,
        'application_users',
        'application_user_type_id',
        'application_id')
        ->withPivot('description');
    }

    public function businessArea(): BelongsTo
    {
        return $this->belongsTo(BusinessArea::class);
    }
}
