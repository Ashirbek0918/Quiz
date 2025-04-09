<?php
declare(strict_types=1);
namespace App\DataObjects\Auth;



use Akbarali\DataObject\DataObjectBase;

class AuthDataObject extends DataObjectBase
{
    public ?string $username;
    public ?string $password;
    public ?string $address;

}
