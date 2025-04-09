<?php
declare(strict_types=1);

namespace App\Services;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Permission\CreatePermissionActionData;
use App\DataObjects\Permission\PermissionData;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class PermissionService
{

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 10, ?iterable $filters = null): DataObjectCollection
    {
        $model = Permission::applyEloquentFilters($filters)
            ->orderBy('permissions.id', 'desc');

        $totalCount = $model->count();
        $skip = $limit * ($page - 1);
        $items = $model->skip($skip)->take($limit)->get();
        $items->transform(function (Permission $permission) {
            return PermissionData::createFromEloquentModel($permission);
        });
        return new DataObjectCollection($items, $totalCount, $limit, $page);
    }


    /**
     * @return Builder[]|Collection
     */
    public function getPermissions(): Collection|array
    {
        return Permission::query()->get()->chunk(4);
    }


    /**
     * @param CreatePermissionActionData $actionData
     * @return PermissionData
     * @throws ValidationException
     */
    public function createPermission(CreatePermissionActionData $actionData): PermissionData
    {
        $actionData->addValidationRule('name', 'unique:permissions,name');
        $actionData->validateException();
        $data = $actionData->all();
        $permission = Permission::query()->create($data);
        return PermissionData::createFromEloquentModel($permission);
    }


    /**
     * @param CreatePermissionActionData $actionData
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function updatePermission(CreatePermissionActionData $actionData, int $id): void
    {
        $actionData->addValidationRule('name', "unique:permissions,name,$id");
        $actionData->validateException();
        $permission = $this->getOne($id);
        $permission->fill($actionData->all());
        $permission->save();
    }

    /**
     * @param int $id
     * @return void
     */
    public function deletePermission(int $id): void
    {
        $permission = $this->getOne($id);
        $permission->delete();
    }

    /**
     * @param int $id
     * @return Permission
     */
    protected function getOne(int $id): Permission
    {
        return Permission::query()->findOrFail($id);
    }
}
