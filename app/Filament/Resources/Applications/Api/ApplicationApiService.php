<?php
namespace App\Filament\Resources\Applications\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\Applications\ApplicationResource;


class ApplicationApiService extends ApiService
{
    protected static string | null $resource = ApplicationResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
