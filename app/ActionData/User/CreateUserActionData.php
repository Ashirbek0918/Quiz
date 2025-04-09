<?php
declare(strict_types = 1);
namespace App\ActionData\User;


use Akbarali\ActionData\ActionDataBase;

class CreateUserActionData extends ActionDataBase
{
    public ?string $username;
    public ?string $password;
    public  ?array $roles;

    protected array $rules = [
        'username' => 'required|unique:users,username',
        'password' => 'required', 'min:4',
        'roles' => 'required|array',
        'roles.*' => 'required|exists:roles,name'
    ];

}
