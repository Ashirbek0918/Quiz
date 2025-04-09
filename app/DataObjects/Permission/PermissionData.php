<?php
declare(strict_types=1);
namespace App\DataObjects\Permission;

use Akbarali\DataObject\DataObjectBase;
use Carbon\Carbon;

class PermissionData extends  DataObjectBase
{
    public int $id;
    public string $name;

    public string $guard_name;

    public Carbon $created_at;
}
