<?php
declare(strict_types = 1);
namespace App\ActionData\User;


use Akbarali\ActionData\ActionDataBase;

class UpdateUserActionData extends ActionDataBase
{
    public ?int $id;
    public ?string $username;
    public ?string $password;
    public ?array $roles;

    protected array $rules = [
        'username'    => 'required',
        'password'    => ['nullable', 'min:8'],
        'roles' => 'nullable|array',
        'roles.*' => 'nullable|string|exists:roles,name'
    ];

}
