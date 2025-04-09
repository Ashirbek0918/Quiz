<?php
declare(strict_types=1);
namespace App\DataObjects\Role;
use Akbarali\DataObject\DataObjectBase;
use Carbon\Carbon;


class RoleData extends DataObjectBase
{
    public int $id;
    public string $name;
    public string $guard_name;
    public Carbon $created_at;
    public ?array $permissions;
}
