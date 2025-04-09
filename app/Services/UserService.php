<?php

declare(strict_types=1);

namespace App\Services;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\User\CreateUserActionData;
use App\ActionData\User\UpdateUserActionData;
use App\ActionData\User\UpdateUserProfileActionData;
use App\DataObjects\User\UserData;
use App\DataObjects\User\UserProfileData;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * @param int $page
     * @param int $limit
     * @param array|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 15, ?array $filters = []): DataObjectCollection
    {
        $query = User::applyEloquentFilters($filters)->with('roles')->orderBy('users.id', 'desc');
        $total = $query->count();
        $skip = ($page - 1) * $limit;
        $items = $query->skip($skip)->take($limit)->get();

        $items->transform(fn(User $user) => UserData::fromModel($user));
        return new DataObjectCollection($items, $total, $limit, $page);
    }

    /**
     * @param CreateUserActionData $actionData
     * @return UserData
     */
    public function createUser(CreateUserActionData $actionData): UserData
    {
        $userModel = User::query()->create([
            'username' => $actionData->username,
            'password' => Hash::make($actionData->password),
        ]);
        $userModel->assignRole($actionData->roles);
        return UserData::createFromEloquentModel($userModel);
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getUsers(): Collection|\Illuminate\Support\Collection
    {
        $users = User::query()->get();
        return $users->transform(fn(User $user) => UserData::fromModel($user));
    }


    /**
     * @param UpdateUserActionData $actionData
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function updateUser(UpdateUserActionData $actionData, int $id): void
    {
        $user = $this->getOne($id);
        $actionData->addValidationRules([
            'username' => 'string|unique:users,username,' . $id
        ]);
        $actionData->validateException();

        $data['username'] = $actionData->username;
        if ($actionData->password != null) {
            $data['password'] = Hash::make($actionData->password);
        }

        $user->update($data);
        $user->syncRoles($actionData->roles);
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteUser($id): void
    {
        $userModel = $this->getOne($id);
        $userModel->delete();
    }

    /**
     * @param int $id
     * @return User
     */
    public function getOne(int $id): User
    {
        return User::query()->with('roles')->findOrFail($id);
    }

    public function edit(int $id): UserProfileData
    {
        return UserProfileData::fromModel($this->getOne($id));
    }

    /**
     * @param UpdateUserProfileActionData $actionData
     * @return void
     * @throws ValidationException
     */
    public function updateProfile(UpdateUserProfileActionData $actionData): void
    {
        $user = auth()->user();
        $actionData->addValidationRules([
            'username' => 'string|unique:users,username,' . $user->id
        ]);
        $actionData->validateException();

        $data['username'] = $actionData->username;
        if ($actionData->password != null) {
            $data['password'] = Hash::make($actionData->password);
        }

        $user->update($data);
    }

}
