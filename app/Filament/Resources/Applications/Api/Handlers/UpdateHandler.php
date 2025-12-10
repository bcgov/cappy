<?php
namespace App\Filament\Resources\Applications\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Applications\ApplicationResource;
use App\Filament\Resources\Applications\Api\Requests\UpdateApplicationRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = ApplicationResource::class;
    protected static string $permission = 'Update:Application';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Application
     *
     * @param UpdateApplicationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateApplicationRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}