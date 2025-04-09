<?php
declare(strict_types = 1);
namespace App\ActionData\Role;

use Akbarali\ActionData\ActionDataBase;

class CreateRoleActionData extends ActionDataBase
{
    public ?int $id;
    public ?string $name;
    public string $guard_name = 'web';
    public ?array $permission_id = [];

    protected array $rules = [
        'name' => "required|string",
        "permission_id" => "nullable|array",
        "permission_id.*" => "string"
    ];
}
