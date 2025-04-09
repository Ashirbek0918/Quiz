<?php
declare(strict_types=1);
namespace App\ActionData\User;

use Akbarali\ActionData\ActionDataBase;

class LoginUserActionData extends ActionDataBase
{
    public string $username;
    public string $password;

    protected array $roles = [
        'username' => 'required|string',
        'password' => 'required|string',
    ];
}
