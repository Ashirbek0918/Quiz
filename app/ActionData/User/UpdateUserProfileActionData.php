<?php

namespace App\ActionData\User;

use Akbarali\ActionData\ActionDataBase;

class UpdateUserProfileActionData extends ActionDataBase
{

    public ?int $id;
    public ?string $username;
    public ?string $password;

    protected array $rules = [
        'username'    => 'required',
        'password'    => ['nullable', 'min:8'],
    ];
}
