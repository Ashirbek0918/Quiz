<?php
declare(strict_types=1);

namespace App\Services;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Role\CreateRoleActionData;
use App\DataObjects\Role\RoleData;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class RoleService
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 20, ?iterable $filters = null): DataObjectCollection
    {
        $model = Role::applyEloquentFilters($filters)
            ->orderBy('roles.id', 'desc');

        $total = $model->count();
        $skip = ($page - 1) * $limit;

        $items = $model->skip($skip)->take($limit)->get();

        $items->transform(fn(Role $role) => RoleData::createFromEloquentModel($role));

        return new DataObjectCollection($items, $total, $limit, $page);
    }

    /**
     * @param CreateRoleActionData $actionData
     * @return RoleData
     * @throws ValidationException
     */
    public function createRole(CreateRoleActionData $actionData): RoleData
    {

        $actionData->addValidationRule('name', "required|string|unique:roles");
        $actionData->validateException();
        $data = $actionData->all();
        $role = Role::query()->create($data);
        $role->syncPermissions($actionData->permission_id);
        return RoleData::createFromEloquentModel($role);
    }

    /**
     * @param CreateRoleActionData $actionData
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function updateRole(CreateRoleActionData $actionData, int $id): void
    {

        $actionData->addValidationRule('name', "unique:roles,name,$id");
        $actionData->validateException();

        $role = $this->getOne($id);
        $role->fill($actionData->all());
        $role->save();
        $role->syncPermissions($actionData->permission_id);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteRole(int $id): void
    {
        $role = $this->getOne($id);
        $role->delete();
    }

    /**
     * @param int $id
     * @return RoleData
     */
    public function getRole(int $id): RoleData
    {

        return RoleData::fromModel($this->getOne($id));
    }

    /**
     * @param int $id
     * @return Role
     */
    protected function getOne(int $id): Role
    {
        return Role::query()->with('permissions')->findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        $roles = Role::query()->get();
        return $roles->transform(fn(Role $role) => RoleData::fromModel($role));
    }
}
