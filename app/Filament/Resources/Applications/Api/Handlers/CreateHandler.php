<?php
namespace App\Filament\Resources\Applications\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Applications\ApplicationResource;
use App\Filament\Resources\Applications\Api\Requests\CreateApplicationRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ApplicationResource::class;
    protected static string $permission = 'Create:Application';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Application
     *
     * @param CreateApplicationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateApplicationRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}