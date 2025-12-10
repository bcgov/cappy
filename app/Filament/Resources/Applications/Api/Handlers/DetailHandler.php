<?php

namespace App\Filament\Resources\Applications\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\Applications\ApplicationResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\Applications\Api\Transformers\ApplicationTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ApplicationResource::class;
    protected static string $permission = 'View:Application';


    /**
     * Show Application
     *
     * @param Request $request
     * @return ApplicationTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ApplicationTransformer($query);
    }
}
