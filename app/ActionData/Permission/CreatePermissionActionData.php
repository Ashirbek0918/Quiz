<?php
declare(strict_types = 1);
namespace App\ActionData\Permission;

use Akbarali\ActionData\ActionDataBase;

class CreatePermissionActionData extends ActionDataBase
{
    public ?int $id;
    public ?string $name;
    public ?string $guard_name = 'web';

    protected array $rules = [
        'name' => "required|string"
    ];
}
