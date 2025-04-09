<?php
declare(strict_types=1);
namespace App\DataObjects\User;


use Akbarali\DataObject\DataObjectBase;
use Carbon\Carbon;


class UserData extends DataObjectBase
{
    public ?int    $id;
    public ?string $username;
//    public Carbon|string $created_at;
    public $roles;
}
